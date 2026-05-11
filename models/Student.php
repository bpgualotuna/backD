<?php

declare(strict_types=1);

namespace Models;


class Student
{
    private string $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $dateOfBirth;
    private string $gender;
    private string $major;
    private float  $gpa;
    private string $enrollmentStatus;
    private int    $creditsCompleted;
    private string $address;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $phone,
        string $dateOfBirth,
        string $gender,
        string $major,
        float  $gpa,
        string $enrollmentStatus,
        int    $creditsCompleted,
        string $address,
        string $id = ''
    ) {
        $this->id               = $id;
        $this->firstName        = $firstName;
        $this->lastName         = $lastName;
        $this->email            = $email;
        $this->phone            = $phone;
        $this->dateOfBirth      = $dateOfBirth;
        $this->gender           = $gender;
        $this->major            = $major;
        $this->gpa              = $gpa;
        $this->enrollmentStatus = $enrollmentStatus;
        $this->creditsCompleted = $creditsCompleted;
        $this->address          = $address;
    }

    
    public function getId(): string               { return $this->id; }
    public function getFirstName(): string        { return $this->firstName; }
    public function getLastName(): string         { return $this->lastName; }
    public function getEmail(): string            { return $this->email; }
    public function getPhone(): string            { return $this->phone; }
    public function getDateOfBirth(): string      { return $this->dateOfBirth; }
    public function getGender(): string           { return $this->gender; }
    public function getMajor(): string            { return $this->major; }
    public function getGpa(): float               { return $this->gpa; }
    public function getEnrollmentStatus(): string { return $this->enrollmentStatus; }
    public function getCreditsCompleted(): int    { return $this->creditsCompleted; }
    public function getAddress(): string          { return $this->address; }

    
    public function setId(string $id): void { $this->id = $id; }

    
    public function toArray(): array
    {
        return [
            'id'               => $this->id,
            'firstName'        => $this->firstName,
            'lastName'         => $this->lastName,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'dateOfBirth'      => $this->dateOfBirth,
            'gender'           => $this->gender,
            'major'            => $this->major,
            'gpa'              => $this->gpa,
            'enrollmentStatus' => $this->enrollmentStatus,
            'creditsCompleted' => $this->creditsCompleted,
            'address'          => $this->address,
        ];
    }
}
