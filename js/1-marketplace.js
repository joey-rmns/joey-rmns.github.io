function ItemGroup(name, pricePerItem, numberOfItems) {
  this.name = name;
  this.pricePerItem = pricePerItem;
  this.numberOfItems = numberOfItems;
}

function Cart(){
this.itemGroups = [];
}

Cart.prototype.addItemGroup = function(itemGroup) {
  this.itemGroups.push(itemGroup);
};

Cart.prototype.getTotalAmount = function() {
  let amount = 0;
  for (let i = 0; i < this.itemGroups.length; i++) {
    const g = this.itemGroups[i];
    amount += g.pricePerItem * g.numberOfItems;
  }
  return amount;
};

Cart.prototype.showTotalAmount = function() {
    this.showTotalAmount = function(){
        if (this.itemGroups.length == 0){
            document.write("<p> You have 0 item, for a total amount of 0$, in your cart! </p>");
        } else  {
          const groupsCount = this.itemGroups.length; 
    const amount = this.getTotalAmount();       
    const TAX_RATE = 0.15;                     
    const totalWithTaxes = amount * (1 + TAX_RATE);

    document.write(
     "<p> You have ${groupsCount} item(s), for a total amount of $${amount.toFixed(2)},
      in your cart! With taxes, this is $${totalWithTaxes.toFixed(2)}.</p>"
        };
    }
};


document.write("<h2> 1) Creating the cart </h2>");
let my_cart = new Cart();
my_cart.showTotalAmount();

document.write("<h2> 2) Adding 15 pants at 10.05$ each to the cart! </h2>");
let pants = new ItemGroup("pants", 10.05, 15);
my_cart.addItemGroup(pants);
my_cart.showTotalAmount();

document.write("<h2> 3) Adding 1 coat at 99.99$ to the cart! </h2>");
let coat = new ItemGroup("coat", 99.99, 1);
my_cart.addItemGroup(coat);
my_cart.showTotalAmount();