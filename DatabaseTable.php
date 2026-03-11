<?php
class DatabaseTable
{
    private PDO $pdo;
    private string $table;
    private string $primaryKey;

    public function __construct(PDO $pdo, string $table, string $primaryKey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    // Get total number of rows
    public function total(): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM `' . $this->table . '`');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // Delete by a field
    public function delete(string $field, $value): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM `' . $this->table . '` WHERE `' . $field . '` = :value');
        $stmt->execute(['value' => $value]);
    }

    // Insert a record
    private function insert(array $values): void
    {
        $fields = implode('`,`', array_keys($values));
        $placeholders = ':' . implode(',:', array_keys($values));
        $stmt = $this->pdo->prepare(
            "INSERT INTO `{$this->table}` (`$fields`) VALUES ($placeholders)"
        );
        $stmt->execute($values);
    }

    // Update a record
    private function update(array $values): void
    {
        if (!isset($values[$this->primaryKey])) {
            throw new Exception("Primary key '{$this->primaryKey}' missing in values array");
        }

        $set = '';
        $params = [];
        foreach ($values as $key => $value) {
            if ($key !== $this->primaryKey) {
                $set .= "`$key` = :$key, ";
                $params[$key] = $value;
            }
        }
        $set = rtrim($set, ', ');
        $params['primaryKey'] = $values[$this->primaryKey];

        $stmt = $this->pdo->prepare(
            "UPDATE `{$this->table}` SET $set WHERE `{$this->primaryKey}` = :primaryKey"
        );
        $stmt->execute($params);
    }

    // Find a record by primary key
    public function findById($id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Find all records
    public function findAll(): array
    {
        // Only order by post_date if it's the posts table
        if ($this->table === 'posts') {
            $stmt = $this->pdo->prepare('SELECT * FROM `' . $this->table . '` ORDER BY post_date DESC, id DESC');
        } else {
            $stmt = $this->pdo->prepare('SELECT * FROM `' . $this->table . '`');
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find records by a specific field
    public function find(string $field, $value): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = :value'
        );
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Save a record (insert or update)
    public function save(array $record): void
    {
        if (empty($record[$this->primaryKey])) {
            unset($record[$this->primaryKey]);
            $this->insert($record);
        } else {
            $this->update($record);
        }
    }

    // Get all posts with authors and categories
    public function allPosts(): array
    {
        if ($this->table !== 'posts') {
            throw new Exception("allPosts() method only works with 'posts' table");
        }

        $stmt = $this->pdo->prepare(
            'SELECT p.id, p.title, p.body AS content, p.image, p.alt_text, p.post_date,
                    a.name AS author_name, c.name AS category_name
             FROM posts p
             LEFT JOIN authors a ON p.author_id = a.id
             LEFT JOIN categories c ON p.category_id = c.id
             ORDER BY p.id DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all comments for a post
    public function commentsByPost(int $post_id): array
    {
        if ($this->table !== 'comments') {
            throw new Exception("commentsByPost() method only works with 'comments' table");
        }

        $stmt = $this->pdo->prepare(
            'SELECT id, post_id, author_name, body, created_at
             FROM comments
             WHERE post_id = :post_id
             ORDER BY created_at DESC'
        );
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all authors
    public function allAuthors(): array
    {
        if ($this->table !== 'authors') {
            throw new Exception("allAuthors() method only works with 'authors' table");
        }

        $stmt = $this->pdo->prepare('SELECT id, name, email FROM authors ORDER BY name ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all categories
    public function allCategories(): array
    {
        if ($this->table !== 'categories') {
            throw new Exception("allCategories() method only works with 'categories' table");
        }

        $stmt = $this->pdo->prepare('SELECT id, name FROM categories ORDER BY name ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}