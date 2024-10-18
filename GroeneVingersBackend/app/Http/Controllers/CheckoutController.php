<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class CheckoutController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('employees.checkout', compact('products'));
    }

    public function store(Request $request)
    {
        // Handle storing the order
        // Store selected products in session
        $selectedProducts = [];
        $totalPrice = 0;

        // Get product IDs and their quantities
        $selectedProductIds = $request->input('products', []);
        $productQuantities = array_count_values($selectedProductIds);

        // Iterate over product IDs and quantities
        foreach ($productQuantities as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $selectedProducts[] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                ];
                $totalPrice += $product->price * $quantity;
            }
        }

        // Store selected products in session
        Session::put('selectedProducts', $selectedProducts);

        // Generate PDF invoice
        $pdfContent = '<h1>Invoice</h1>';
        $pdfContent .= '<ul>';
        foreach ($selectedProducts as $product) {
            $pdfContent .= '<li>'.$product['name'].' - $'.$product['price'].'</li>';
        }
        $pdfContent .= '</ul>';
        $pdfContent .= '<h3>Total Price: $'.$totalPrice.'</h3>';
        $customerName = $request->input('customer_name');
        $customerAddress = $request->input('address');
        $zipCode = $request->input('postcode'); // Corrected variable name
        $fullAddress = "$customerAddress, $zipCode";
        $pdfContent .= view('employees.invoice', compact('customerName', 'selectedProducts', 'totalPrice', 'customerName', 'fullAddress'))->render();

        // Generate PDF
        $pdf = new Dompdf();
        $pdf->loadHTML($pdfContent);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        // Stream or save the PDF file
        return $pdf->stream('invoice.pdf');
    }
}
