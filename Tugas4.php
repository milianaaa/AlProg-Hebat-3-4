<?php
ob_start(); // mulai menampung output

// Class untuk node barang
class ItemNode {
    public $itemName;
    public $quantity;
    public $next;

    public function __construct($itemName, $quantity) {
        $this->itemName = $itemName;
        $this->quantity = $quantity;
        $this->next = null;
    }
}

// Class untuk manajemen inventori
class InventoryManagement {
    private $head = null;
    private $tail = null;

    public function addItem($itemName, $quantity) {
        $newItem = new ItemNode($itemName, $quantity);
        
        if ($this->head == null) {
            $this->head = $newItem;
            $this->tail = $newItem;
            $this->tail->next = $this->head;
        } else {
            $this->tail->next = $newItem;
            $this->tail = $newItem;
            $this->tail->next = $this->head;
        }
    }

    public function displayInventory() {
        if ($this->head == null) {
            return "Inventory is empty\n";
        }

        $current = $this->head;
        $output = "\n=== INVENTORY REPORT ===\n";
        $output .= str_pad("ITEM NAME", 20) . str_pad("QUANTITY", 15) . "\n";
        $output .= str_repeat("-", 35) . "\n";
        
        do {
            $output .= str_pad($current->itemName, 20) . 
                      str_pad($current->quantity, 15) . "\n";
            $current = $current->next;
        } while ($current !== $this->head);

        return $output;
    }
}

// Class untuk node log
class LogNode {
    public $itemName;
    public $quantity;
    public $timestamp;
    public $next;
    public $prev;

    public function __construct($itemName, $quantity, $timestamp) {
        $this->itemName = $itemName;
        $this->quantity = $quantity;
        $this->timestamp = $timestamp;
        $this->next = null;
        $this->prev = null;
    }
}

// Class untuk manajemen log transaksi
class TransactionLog {
    private $head = null;
    private $tail = null;

    public function addTransaction($itemName, $quantity) {
        $timestamp = date("Y-m-d H:i:s");
        $newLog = new LogNode($itemName, $quantity, $timestamp);
        
        if ($this->head == null) {
            $this->head = $newLog;
            $this->tail = $newLog;
            $this->tail->next = $this->head;
            $this->head->prev = $this->tail;
        } else {
            $this->tail->next = $newLog;
            $newLog->prev = $this->tail;
            $this->tail = $newLog;
            $this->tail->next = $this->head;
            $this->head->prev = $this->tail;
        }
    }

    public function displayLogs() {
        if ($this->head == null) {
            return "No transaction logs available\n";
        }

        $current = $this->head;
        $output = "\n=== TRANSACTION LOGS ===\n";
        $output .= str_pad("TIMESTAMP", 20) . str_pad("ITEM", 15) . str_pad("QTY", 10) . "\n";
        $output .= str_repeat("-", 45) . "\n";
        
        do {
            $output .= str_pad($current->timestamp, 20) . 
                      str_pad($current->itemName, 15) . 
                      str_pad($current->quantity, 10) . "\n";
            $current = $current->next;
        } while ($current !== $this->head);

        return $output;
    }
}

// ================= Program =================

echo "=== MANAGEMENT INVENTARIS ===\n";

// Inisialisasi dan isi data
$inventory = new InventoryManagement();
$inventory->addItem("Laptop", 10);
$inventory->addItem("Printer", 5);
$inventory->addItem("Scanner", 3);

$log = new TransactionLog();
$log->addTransaction("Laptop", 2);
$log->addTransaction("Printer", 1);
$log->addTransaction("Scanner", 1);

// Tampilkan output
echo $inventory->displayInventory();
echo $log->displayLogs();

$output = ob_get_clean(); // ambil semua output di buffer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ManagementInventaris</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Courier New', monospace;
            padding: 20px;
        }
        .output {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            color: #333;
            white-space: pre;
            font-size: 16px;
            line-height: 1.5;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <h1>Management Inventaris</h1>
    <div class="output">
        <?php echo $output; ?>
    </div>
</body>
</html>