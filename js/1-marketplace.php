<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
</head>
<body>
    <?php require_once 'nav.php'; ?>
    
    <main>
        <h1>Marketplace</h1>
        
        <div id="cart-output">
            <?php
            // PHP version of the Cart functionality
            class ItemGroup {
                public $name;
                public $pricePerItem;
                public $numberOfItems;
                
                public function __construct($name, $pricePerItem, $numberOfItems) {
                    $this->name = $name;
                    $this->pricePerItem = $pricePerItem;
                    $this->numberOfItems = $numberOfItems;
                }
            }
            
            class Cart {
                public $itemGroups = [];
                
                public function addItemGroup($itemGroup) {
                    $this->itemGroups[] = $itemGroup;
                }
                
                public function getTotalAmount() {
                    $amount = 0;
                    foreach ($this->itemGroups as $group) {
                        $amount += $group->pricePerItem * $group->numberOfItems;
                    }
                    return $amount;
                }
                
                public function showTotalAmount() {
                    if (count($this->itemGroups) == 0) {
                        echo "<p>You have 0 item, for a total amount of $0, in your cart!</p>";
                    } else {
                        $groupsCount = count($this->itemGroups);
                        $amount = $this->getTotalAmount();
                        $TAX_RATE = 0.15;
                        $totalWithTaxes = $amount * (1 + $TAX_RATE);
                        
                        echo "<p>You have {$groupsCount} item(s), for a total amount of $" . number_format($amount, 2) . 
                             " in your cart! With taxes, this is $" . number_format($totalWithTaxes, 2) . ".</p>";
                    }
                }
            }
            
            // Creating the cart
            echo "<h2>1) Creating the cart</h2>";
            $my_cart = new Cart();
            $my_cart->showTotalAmount();
            
            // Adding pants
            echo "<h2>2) Adding 15 pants at $10.05 each to the cart!</h2>";
            $pants = new ItemGroup("pants", 10.05, 15);
            $my_cart->addItemGroup($pants);
            $my_cart->showTotalAmount();
            
            // Adding coat
            echo "<h2>3) Adding 1 coat at $99.99 to the cart!</h2>";
            $coat = new ItemGroup("coat", 99.99, 1);
            $my_cart->addItemGroup($coat);
            $my_cart->showTotalAmount();
            ?>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
</body>
</html>