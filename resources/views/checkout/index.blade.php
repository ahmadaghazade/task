<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans bg-indigo-900" dir="rtl">

<div class="container mx-auto mt-8">
    <div class="max-w-md mx-auto bg-white p-8 border shadow-md">
        <h2 class="text-2xl font-semibold mb-6">سفارش شما</h2>

        <!-- Product 1 -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-gray-700">محصول 1</span>
            <span class="text-gray-700">2500ريال</span>
        </div>

        <!-- Product 2 -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-gray-700">محصول 2</span>
            <span class="text-gray-700">2500ريال</span>
        </div>

        <!-- Total -->
        <div class="flex justify-between items-center border-t pt-4 mt-4">
            <span class="text-xl font-semibold">مجموع:</span>
            <span class="text-xl font-semibold">5000ريال</span>
        </div>

        

        <!-- Checkout Form -->
        <form action="{{ route('create.payment') }}" method="post" class="mt-6">
            @csrf
            <div class="mt-4">
                <label for="card_number" class="block text-gray-700 text-sm font-semibold mb-2">شماره کارت شما:</label>
                <input type="text" id="card_number" name="card_number" class="w-full px-4 py-2 border rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 mt-4 rounded-lg text-white font-semibold px-4 py-2 w-full">تکمیل خرید</button>
        </form>
    </div>
</div>

</body>
</html>
