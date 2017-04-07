<?php

class Book implements JsonSerializable {

    private $id;
    private $title;
    private $author;
    private $description;

    public function __construct() {
        $this->id = -1;
        $this->setAuthor('');
        $this->setTitle('');
        $this->setDescription('');
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function create(PDO $conn) {
        $stmt = $conn->prepare('INSERT INTO books SET author=:author, title=:title, description=:description');
        $result = $stmt->execute([
            'author' => $this->getAuthor(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
        ]);
        $insertedId = $conn->lastInsertId();
        if ($insertedId > 0) {
            $this->id = $insertedId;
            return [json_encode($this)];
        } else {
            return [];
        }
    }

    public function update(PDO $conn) {

        $stmt = $conn->prepare('UPDATE books SET author=:author, title=:title, description=:description WHERE id=:id');
        $result = $stmt->execute([
            'id' => $this->getId(),
            'author' => $this->getAuthor(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
        ]);
        if ($result) {
            return [json_encode($this)];
        } else {
            return [];
        }
    }

    public function delete(PDO $conn) {
        $id = $this->getId();
        $sql = "DELETE FROM books WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        if ($result === true) {
            $this->id = -1;
            return [json_encode($this)];
        } else {
            return [];
        }
    }

    //function loadinf single row from db
    static public function loadFromDb(PDO $conn, $id) {
        $stmt = $conn->prepare('SELECT * FROM books WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result && $stmt->rowCount() > 0) {
            $row = $stmt->fetch();

            $book = new Book();
            $book->id = $row['id'];
            $book->author = $row['author'];
            $book->title = $row['title'];
            $book->description = $row['description'];
            //implement json object interfejs
            return $book;
        } else {
            return [];
        }
    }

    //function loading all from db
    static public function loadAllFromDb(PDO $conn) {
        $result = $conn->query('SELECT * FROM books');
        $books = [];
        //$result is array 
        foreach ($result as $row) {
            //creating new object from single book 
            $book = new Book();
            $book->id = $row['id'];
            $book->author = $row['author'];
            $book->title = $row['title'];
            $book->description = $row['description'];
            //pushing book into array 
            $books[] = json_encode($book);
        }

        return $books;
    }

    public function jsonSerialize() {
        //interfejs method
        //this array will be return after sending object to json_encode()
        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

}
