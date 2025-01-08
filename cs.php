<?php
session_start();
require_once "connection.php";

$conn = getConnection();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head content here -->
    <title>Layaran Informasi</title>
</head>
<style>
    * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "Poppins", sans-serif;
            }

            body {
                font-family: Arial, sans-serif;
            }

            .topbar {
  position: fixed;
  top: 0;
  height: 50px;
  width: 100%;
  background-color: #05992f;
  display: flex;
  align-items: center;
  padding: 0 15px;
  justify-content: space-between; 
  color: white;
}

#signout-link {
  color: white;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
  margin-right: 20px;
}

.sidebar {
  position: fixed;
  top: 50px;
  left: 0;
  width: 90px;
  height: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  background: rgba(3, 3, 3, 0.8);
  backdrop-filter: blur(17px);
  --webkit-backdrop-filter: blur(17px);
  border-right: 1px solid rgba(255, 0, 0, 0, 1);
  transition: width 0.3s ease;
}
            .sidebar:hover {
                width: 260px;
            }

            .sidebar .logo {
                color: #000;
                display: flex;
                align-items: center;
                padding: 25px 10px 15px;
            }

            .logo span {
                color: orange;
            }

            .logo img {
                width: 43px;
                border-radius: 50%;
            }

            .logo h2 {
                font-size: 1.15rem;
                font-weight: 600;
                margin-left: 15px;
                display: none;
            }

            .sidebar:hover .logo h2 {
                display: block;
            }

            .sidebar .links {
                list-style: none;
                margin-top: 20px;
                overflow-y: auto;
                scrollbar-width: none;
                height: calc(100%);
            }

            .sidebar .links::-webkit-scrollbar {
                display: none;
            }

            .links li {
                display: flex;
                border-radius: 4px;
                align-items: center;
                transition: background-color 0.3s ease;
            }

            .links li:hover {
                background: #05992f;
                cursor: pointer;
            }

            .links h4 {
                color: #222;
                font-weight: 500;
                display: none;
                margin-bottom: 10px;
                transition: display 0.3s ease;
            }

            .sidebar:hover .links h4 {
                display: block;
            }

            .links hr {
                margin: 10px 8px;
                border: 1px solid #4c4c4c;
                transition: border-color 0.3s ease;
            }

            .sidebar:hover .links hr {
                border-color: transparent;
            }

            .links li span {
                padding: 12px 10px;
            }

            .links li a {
                padding: 10px;
                color: #000;
                display: none;
                font-weight: 500;
                white-space: nowrap;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .sidebar:hover .links li a {
                display: block;
            }

            .links .logout-link {
                margin-top: 20px;
            }

            .links li:hover a {
                color: white;
            }

            .sidebar:hover .links li a {
                display: block;
            }

            .links .logout-link {
                margin-top: 20px;
            }

            .links li:hover a {
                color: white;
            }

            .links h4 {
                color: #222;
                font-weight: 500;
                display: none;
                margin-bottom: 10px;
            }

            .sidebar:hover .links h4 {
                display: block;
            }

            .links hr {
                margin: 10px 8px;
                border: 1px solid #4c4c4c;
            }

            .sidebar:hover .links hr {
                border-color: transparent;
            }

            .links li span {
                padding: 12px 10px;
            }

            .links li a {
                padding: 10px;
                color: white;
                display: none;
                font-weight: 500;
                white-space: nowrap;
                text-decoration: none;
            }

            .sidebar:hover .links li a {
                display: block;
            }
    .cs-container {
        margin: auto;
        text-align: center;
        align-items: center;
        background-color: #ffffff;
        padding: 1.25em 0.9em;
        border-radius: 0.3em;
        box-shadow: 0 0.6em 1.2em #1c0050;
        width: 40%;
        margin-top: 80px;
        animation: fadeIn 1s ease-in-out; 
    }

    h1{
        margin-bottom: 20px;
        animation: slideInUp 1s ease-in-out;
    }
    h3 {
        color: #05992f;
        margin-bottom: 20px;
        animation: slideInUp 1s ease-in-out; 
    }

    .image img,
    .second-image img {
        height: auto;
        animation: scaleIn 1s ease-in-out; 
    }
    a:link, a:visited {
    text-decoration: none;
  }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
</style>

<body>
<div class="topbar">
        <h4 style="color:white">Welcome <?php echo $_SESSION["username"]; ?> !</h4>
        <a href="logout.php" id="signout-link">Sign Out</a>
    </div>
    <aside class="sidebar">
        <div class="container">
            <div class="logo">
            <!-- <img src="img/logo.png" alt="logo"> -->
            <h2>BUKU<span>KAS</span></h2>
            </div>
        <ul class="links">
            <h4>Main Menu</h4>
            <li>
            <span><img src="img/dash (2).png" alt="Dashboard"></span>
            <a href="dashboard.php">Dashboard</a>
            </li>
                    
            <h4>Transaction</h4>
            <li>
                <span><img src="img/cashinn.png" alt="Dashboard"></span>
            <a href="CashIn.php">Cash In</a>
            </li>
            <li>
            <span><img src="img/cashoutt.png" alt="Dashboard"></span>
            <a href="CashOut.php">Cash Out</a>
            </li>
        <li>
            <span><img src="img/debtt.png" alt="Dashboard"></span>
            <a href="debt.php">Debt</a>
        </li>
            <li>
            <span> <img src="img/tax.png" alt="Dashboard"></span>
            <a href="tax.php">Tax</a>
        </li>
            <li>
            <span> <img src="img/reportt.png" alt="Dashboard"></span>
            <a href="reports.php">Reports</a>
        </li> -->
            <li>
            <span> <img src="img/layanan.png" alt="Dashboard"></span>
            <a href="cs.php">Layanan Informasi</a>
        </li>
        </ul>
        </aside>
    <div class="cs-container">
        <h1>Layanan Informasi</h1>

        <div class="image-container">
            <a href="https://www.instagram.com/bukukas.co.id?utm_source=ig_web_button_share_sheet&igsh=OGQ5ZDc2ODk2ZA==" class="image">
                <img src="img/iconig.png" alt="ig" />
            </a>
            <div class="text-container">
                <a href="https://www.instagram.com/bukukas.co.id?utm_source=ig_web_button_share_sheet&igsh=OGQ5ZDc2ODk2ZA==">
                    <h3>Admin Instagram</h3>
                </a>
            </div>
        </div>
        <div class="image-container">
            <a href="https://wa.me/6281349579566?text=Halo admin Iqbal, saya ada beberapa keluhan" class="image">
                <img src="img/iconwa.png" alt="wa" />
            </a>
            <div class="text-container">
                <a href="https://wa.me/6281349579566?text=Halo admin Iqbal, saya ada beberapa keluhan">
                    <h3>Admin 1</h3>
                </a>
            </div>
        </div>
        <div class="image-container">
            <a href="https://wa.me/6285156891309?text=Halo admin yoga, saya ada keluhan"class="image">
                <img src="img/iconwa.png" alt="twitter" />
            </a>
            <div class="text-container">
                <a href="https://wa.me/6285156891309?text=Halo admin yoga, saya ada keluhan">
                    <h3>Admin 2</h3>
                </a>
            </div>
        </div>
        <div class="image-container">
            <a href="https://wa.me/6288217139228?text=Halo admin Bimo, saya ada keluhan" class="image">
                <img src="img/iconwa.png" alt="twitter" />
            </a>
            <div class="text-container">
                <a href="https://wa.me/6288217139228?text=Halo admin Bimo, saya ada keluhan">
                    <h3>Admin 3</h3>
                </a>
            </div>
        </div>
</div>
</body>

</html>
