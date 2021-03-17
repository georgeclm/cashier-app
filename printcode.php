<?php
require __DIR__ . './vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
/* A wrapper to do organise item names & prices into columns */

class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '')
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 38;

        $left = str_pad($this->name, $leftCols);

        $right = str_pad($this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
/* Fill in your own connector here */

$connector = new FilePrintConnector("php://stdout");

/* Information for the receipt */
$items = array(
    new item("Example item #1", "6.000"),
    new item("Another thing", "9.000"),
    new item("Something else", "20.000"),
    new item("A final item", "50.000"),
);
$subtotal = new item('Subtotal', '85.000');
$tax = new item('A local tax', '8.500');
$total = new item('Total', '93.500');
/* Date is kept the same for testing */
$date = date('l jS \of F Y h:i:s A');
// $date = "Monday 6th of April 2015 02:56:25 PM";

/* Start the printer */
// $logo = EscposImage::load("public/img/github.png", false);
$printer = new Printer($connector);

/* Print top logo */
// $printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->graphics($logo);

/* Name of shop */
// $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer->text(" ExampleMart Ltd.\n");
// $printer->selectPrintMode();
$printer->text(" Shop No. 42.\n");
$printer->feed();

/* Title of receipt */
$printer->setEmphasis(true);
$printer->text("SALES INVOICE\n");
$printer->setEmphasis(false);

/* Items */
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->setEmphasis(true);
$printer->text(new item('', 'Rp.'));
$printer->setEmphasis(false);
foreach ($items as $item) {
    $printer->text($item);
}
$printer->setEmphasis(true);
$printer->text($subtotal);
$printer->setEmphasis(false);
$printer->feed();

/* Tax and total */
$printer->text($tax);
// $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer->text($total);

$printer->selectPrintMode();

/* Footer */
$printer->feed();
$printer->feed();
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Thank you for shopping at ExampleMart\n");
$printer->text("For trading hours, please visit example.com\n");
$printer->feed();
$printer->feed();
$printer->text($date . "\n");

/* Cut the receipt and open the cash drawer */
$printer->cut();
$printer->pulse();

$printer->close();
