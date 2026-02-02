<?php
require_once 'database.php';

// Create test customer account
$customer_sql = "INSERT INTO users (username, password, full_name, email, phone, address, role) 
                 VALUES (?, ?, ?, ?, ?, ?, 'customer')";
$customer_username = "testcustomer";
$customer_password = password_hash("123456", PASSWORD_DEFAULT);
$customer_fullname = "Test Customer";
$customer_email = "testcustomer@gmail.com";
$customer_phone = "0123456789";
$customer_address = "123 Test Street";

if ($stmt = mysqli_prepare($conn, $customer_sql)) {
    mysqli_stmt_bind_param($stmt, "ssssss", 
        $customer_username, 
        $customer_password, 
        $customer_fullname, 
        $customer_email, 
        $customer_phone, 
        $customer_address
    );
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Test customer account created successfully!<br>";
        echo "Username: testcustomer<br>";
        echo "Password: 123456<br>";
        echo "Email: testcustomer@gmail.com<br>";
    } else {
        echo "Error creating customer account: " . mysqli_error($conn) . "<br>";
    }
    mysqli_stmt_close($stmt);
}

// Create test admin account
$admin_sql = "INSERT INTO admins (username, password, full_name, email, role) 
              VALUES (?, ?, ?, ?, 'admin')";
$admin_username = "testadmin";
$admin_password = password_hash("123456", PASSWORD_DEFAULT);
$admin_fullname = "Test Admin";
$admin_email = "testadmin@gmail.com";

if ($stmt = mysqli_prepare($conn, $admin_sql)) {
    mysqli_stmt_bind_param($stmt, "ssss", 
        $admin_username, 
        $admin_password, 
        $admin_fullname, 
        $admin_email
    );
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Test admin account created successfully!<br>";
        echo "Username: testadmin<br>";
        echo "Password: 123456<br>";
        echo "Email: testadmin@gmail.com<br>";
    } else {
        echo "Error creating admin account: " . mysqli_error($conn) . "<br>";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?> 