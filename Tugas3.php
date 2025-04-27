<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warehouse Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 20px;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        h2 {
            color: #3498db;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        pre {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', Courier, monospace;
            white-space: pre-wrap;
            margin: 15px 0 0 0;
        }
        .system-title {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="system-title">WAREHOUSE MANAGEMENT SYSTEM</div>
    
    <?php
    // Inisialisasi dan isi data
    $inventory = new InventoryManagement();
    $inventory->addItem("Laptop", 10);
    $inventory->addItem("Printer", 5);
    $inventory->addItem("Scanner", 3);

    $log = new TransactionLog();
    $log->addTransaction("Laptop", 2);
    $log->addTransaction("Printer", 1);
    $log->addTransaction("Scanner", 1);
    ?>

    <div class="section">
        <h2>Inventory Report</h2>
        <pre><?php echo $inventory->displayInventory(); ?></pre>
    </div>

    <div class="section">
        <h2>Transaction Logs</h2>
        <pre><?php echo $log->displayLogs(); ?></pre>
    </div>
</div>

</body>
</html>