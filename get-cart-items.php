<?php 
//SELECT p.name, p.description, p.cost, ci.id, ci.quantity, i.alt_text, i.file_path, i.caption FROM `cart_items` as ci JOIN `cart` ON ci.cart_id = cart.id JOIN `products` as p ON ci.product_id = p.id JOIN images as i ON i.id=p.image_id WHERE cart.user_id = 2

// METHOD GET
// GETS cart id via query string (GET)
// returns items in cart
// $cartItems = [
//     [
//         'product_name' => 'Cupcake',
//         'product_cost' => 200,
//         'cart_item_quantity' => 2,
//         'image' => [
//             'src' => '/image/path.jpg',
//             'alt' => 'This is a product image'
//         ],
//         'user_id' => 1,
//         'cart_id' => 1,
//         'product_id' => 2
//     ]
// ];