<?php

declare(strict_types=1);

namespace Repositories;

use Config\Database;
use Models\Student;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;


class StudentRepository
{
    private const COLLECTION = 'students';

    private Collection $collection;

    public function __construct()
    {
        $this->collection = Database::getInstance()
            ->getDb()
            ->selectCollection(self::COLLECTION);
    }

    
    public function create(Student $student): Student
    {
        $document = [
            'firstName'        => $student->getFirstName(),
            'lastName'         => $student->getLastName(),
            'email'            => $student->getEmail(),
            'phone'            => $student->getPhone(),
            'dateOfBirth'      => $student->getDateOfBirth(),
            'gender'           => $student->getGender(),
            'major'            => $student->getMajor(),
            'gpa'              => $student->getGpa(),
            'enrollmentStatus' => $student->getEnrollmentStatus(),
            'creditsCompleted' => $student->getCreditsCompleted(),
            'address'          => $student->getAddress(),
        ];

        $result = $this->collection->insertOne($document);
        $student->setId((string) $result->getInsertedId());

        return $student;
    }

    
    public function findById(string $id): ?Student
    {
        try {
            $objectId = new ObjectId($id);
        } catch (\Exception $e) {
            return null; 
        }

        $document = $this->collection->findOne(['_id' => $objectId]);

        if ($document === null) {
            return null;
        }

        return $this->mapDocumentToStudent($document);
    }

    public function findAll(): array
    {
        $cursor = $this->collection->find([]);

        return array_map(
            [$this, 'mapDocumentToStudent'],
            $cursor->toArray()
        );
    }

    
    private function mapDocumentToStudent(object $document): Student
    {
        return new Student(
            (string) ($document->firstName        ?? ''),
            (string) ($document->lastName         ?? ''),
            (string) ($document->email            ?? ''),
            (string) ($document->phone            ?? ''),
            (string) ($document->dateOfBirth      ?? ''),
            (string) ($document->gender           ?? ''),
            (string) ($document->major            ?? ''),
            (float)  ($document->gpa              ?? 0.0),
            (string) ($document->enrollmentStatus ?? ''),
            (int)    ($document->creditsCompleted ?? 0),
            (string) ($document->address          ?? ''),
            (string) ($document->_id)
        );
    }
}
