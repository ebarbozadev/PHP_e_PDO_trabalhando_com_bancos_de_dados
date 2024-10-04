<?php

namespace Alura\Pdo\Domain\Model;

class Student
{
    // Colocamos os atributos do nosso modelo
    // Colocamos o ? para dizer que o valor pode ser nulo
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;

    /** @var Phone[] */
    private array $phones = [];

    // Criar um novo usuário
    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    // Pegar ID
    public function id(): ?int
    {
        return $this->id;
    }

    // Pegar nome
    public function name(): string
    {
        return $this->name;
    }

    // Mudança de nome
    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    // Pegar Data de nascimento
    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    // Irá retornar a idade
    public function age(): int
    {
        return $this->birthDate
            // diff é utilizado para calcular diferença entre duas datas
            ->diff(new \DateTimeImmutable())
            // Pegamos a diferença em anos (y -> years)
            ->y;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }

    /** @return Phone[] */
    public function phones(): array
    {
        return $this->phones;
    }

    public function formattedPhone(): string
    {
        return "($this->areaCode) $this->number";
    }
}
