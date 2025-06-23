<?php
require_once __DIR__ . '/../core/ORMinterface.php';


abstract class BaseModel implements ORMinterface {
    protected $table;
    protected $primaryKey;

    // يجب أن يعيد مصفوفة الحقول التي سيتم حفظها في قاعدة البيانات (باستثناء المفتاح الأساسي)
    abstract protected function getFields(): array;

    public function getID() {
        return $this->{$this->primaryKey};
    }

    public function save() {
        global $pdo;

        $fields = $this->getFields();
        $columns = array_keys($fields);

        if ($this->{$this->primaryKey} === null) {
            // INSERT
            $colsStr = implode(", ", $columns);
            $placeholders = ":" . implode(", :", $columns);

            $stmt = $pdo->prepare("INSERT INTO {$this->table} ($colsStr) VALUES ($placeholders)");
            $stmt->execute($fields);

            $this->{$this->primaryKey} = $pdo->lastInsertId();
        } else {
            // UPDATE
            $updateFields = [];
            foreach ($columns as $col) {
                $updateFields[] = "$col = :$col";
            }
            $updateStr = implode(", ", $updateFields);

            $fields[$this->primaryKey] = $this->{$this->primaryKey};
            $stmt = $pdo->prepare("UPDATE {$this->table} SET $updateStr WHERE {$this->primaryKey} = :{$this->primaryKey}");
            $stmt->execute($fields);
        }
    }

    public function delete() {
        global $pdo;

        if ($this->{$this->primaryKey} === null) {
            throw new Exception("Object does not exist in database.");
        }

        $stmt = $pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute([':id' => $this->{$this->primaryKey}]);

        // تنظيف الحقول بعد الحذف
        $this->{$this->primaryKey} = null;
        foreach ($this->getFields() as $key => $value) {
            $this->$key = null;
        }
    }

    public static function findByID($id) {
        global $pdo;
        $class = get_called_class();
        $tmp = new $class();

        $stmt = $pdo->prepare("SELECT * FROM {$tmp->table} WHERE {$tmp->primaryKey} = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $class::fromArray($data) : null;
    }

    public static function findAll() {
        global $pdo;
        $class = get_called_class();
        $tmp = new $class();

        $stmt = $pdo->query("SELECT * FROM {$tmp->table}");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$class, 'fromArray'], $rows);
        
    }
    public static function getAll()
{
    return self::findAll();
}

    abstract public static function fromArray(array $data);
}
