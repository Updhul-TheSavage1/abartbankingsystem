<?php
require_once "../transactions/transact_func.php";
$customer = new customer();

/* =========================================
   ADD CUSTOMER
   ========================================= */

if (isset($_POST['add'])) {

    $n_customer = $customer->new_customer($_POST);

    if ($n_customer["check"]) {

        header("location: customer.php");
        exit();

    } else {

        $errors = [];

        $errors['surname'] = $n_customer['surname'];
        $errors['othername'] = $n_customer['othername'];
        $errors['phoneE'] = $n_customer['phoneE'];
        $errors['genderE'] = $n_customer['genderE'];
        $errors['locationE'] = $n_customer['locationE'];

        $Sname = $n_customer['Sname'];
        $Oname = $n_customer['Oname'];
        $phone = $n_customer['phone'];
        $gender = $n_customer['gender'];
        $location = $n_customer['location'];
    }
}


/* =========================================
   FETCH CUSTOMERS
   ========================================= */

$all_customers = $customer->fetch_customer_data(0);


/* =========================================
   DISPLAY CUSTOMERS
   ========================================= */

function display(array $result)
{
    foreach ($result as $row) {

        $name = $row['surname'] . ' ' . $row['othername'];

        echo '
            <tr>

                <td data-label="ID">
                    <span class="customer-id">
                        ' . $row['customer_id'] . '
                    </span>
                </td>

                <td data-label="Name">

                    <div class="customer-name">

                        <div class="customer-avatar">
                            ' . strtoupper(substr($row['surname'], 0, 1)) . '
                        </div>

                        <div>
                            <span class="name-main">
                                ' . $name . '
                            </span>

                            <span class="name-label">
                                Customer
                            </span>
                        </div>

                    </div>

                </td>

                <td data-label="Gender">

                    <span class="gender-badge">
                        ' . $row['gender'] . '
                    </span>

                </td>

                <td data-label="Action" class="action-cell">

                    <a
                        href="viewcustomer.php?uid=' . $row['customer_id'] . '"
                        class="view-btn"
                    >
                        <span class="btn-icon">
                            View
                        </span>

                        <span>
                            Details
                        </span>
                    </a>

                </td>

            </tr>
        ';
    }
}


/* =========================================
   NO RECORDS
   ========================================= */

function no_records($check)
{
    if ($check == 1) {

        echo '
            <tr>

                <td colspan="4" class="no-records-cell">

                    <div class="no-records-wrapper">

                        <div class="no-records-icon">
                            🔍
                        </div>

                        <h3>
                            No matching customer records
                        </h3>

                        <p>
                            We could not find any customer matching your search.
                        </p>

                        <div class="back-btn-container">

                            <a
                                href="../customer/customer.php"
                                class="back-btn"
                            >
                                <span>←</span>
                                Go Back
                            </a>

                        </div>

                    </div>

                </td>

            </tr>
        ';

    } else {

        echo '
            <tr>

                <td colspan="4" class="no-records-cell">

                    <div class="no-records-wrapper">

                        <div class="no-records-icon">
                            👥
                        </div>

                        <h3>
                            No customer records found
                        </h3>

                        <p>
                            Customer records will appear here once they are added.
                        </p>

                    </div>

                </td>

            </tr>
        ';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Customers</title>

    <!-- Sidebar CSS -->
    <link
        rel="stylesheet"
        type="text/css"
        href="../../style/sidebar.css"
    >

    <!-- Customer CSS -->
    <link
        rel="stylesheet"
        type="text/css"
        href="../../style/customer/customer.css"
    >

</head>


<?php


include "../adincludes/sidebar.php";
?>


<body>
    <?php include "../adincludes/header.php"; ?>
<div class="main-content">


    <!-- =========================================
         PAGE HEADER
         ========================================= -->

    <div class="page-header">

        <div class="page-title">

            <span class="page-label">
                CUSTOMER MANAGEMENT
            </span>

            <h1>
                Customers
            </h1>

            <p>
                Manage and view all registered customers.
            </p>

        </div>


        <button
            type="button"
            class="add-btn"
            onclick="openCustomerModal()"
        >

            <span class="add-icon">
                +
            </span>

            Add Customer

        </button>

    </div>



    <!-- =========================================
         CUSTOMER SUMMARY
         ========================================= -->

    <div class="customer-summary">

        <div class="summary-card">

            <div class="summary-icon">
                👥
            </div>

            <div class="summary-info">

                <span>
                    Total Customers
                </span>

                <strong>

                    <?php

                    if (mysqli_num_rows($all_customers) > 0) {

                        echo mysqli_num_rows($all_customers);

                    } else {

                        echo "0";

                    }

                    ?>

                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                ✓
            </div>

            <div class="summary-info">

                <span>
                    Status
                </span>

                <strong class="active-text">
                    Active
                </strong>

            </div>

        </div>

    </div>



    <!-- =========================================
         SEARCH SECTION
         ========================================= -->

    <div class="search-section">

        <div class="search-heading">

            <div>

                <h2>
                    Customer Directory
                </h2>

                <p>
                    Search through registered customers.
                </p>

            </div>

        </div>


        <div class="search-box">

            <form
                method="GET"
                action=""
            >

                <div class="search-input-wrapper">

                    <span class="search-icon">
                        ⌕
                    </span>

                    <input
                        type="text"
                        name="info"
                        value="<?= isset($_GET['Search']) ? htmlspecialchars($_GET['info']) : '' ?>"
                        placeholder="Search by customer information..."
                        autocomplete="off"
                    >

                </div>


                <button
                    class="search-btn"
                    type="submit"
                    id="srch-btn"
                    name="Search"
                >
                    Search
                </button>


                <?php if (isset($_GET['Search'])): ?>

                    <a
                        href="../customer/customer.php"
                        class="clear-search"
                    >
                        Clear
                    </a>

                <?php endif; ?>

            </form>

        </div>

    </div>



    <!-- =========================================
         CUSTOMER TABLE
         ========================================= -->

    <div class="table-section">

        <div class="table-header">

            <div>

                <h2>
                    Registered Customers
                </h2>

                <p>
                    Customer information and account details
                </p>

            </div>


            <span class="table-count">
                Customer List
            </span>

        </div>


        <div class="tbl-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Gender
                        </th>

                        <th class="action-heading">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    if (isset($_GET['Search'])) {

                        $info = $_GET['info'];

                        if (empty($info)) {

                            no_records(1);

                        } else {

                            $result = $customer->searchCustomer($info);

                            $count = $result->num_rows;

                            if ($count > 0) {

                                $row = $result->fetch_all(MYSQLI_ASSOC);

                                display($row);

                            } else {

                                no_records(1);

                            }

                        }

                    } else {

                        if (mysqli_num_rows($all_customers) > 0) {

                            $customers =
                                $all_customers->fetch_all(MYSQLI_ASSOC);

                            display($customers);

                        } else {

                            no_records(0);

                        }

                    }

                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>



<!-- =========================================
     ADD CUSTOMER MODAL
     ========================================= -->

<div
    class="customer-modal"
    id="customerModal"
>


    <!-- Modal Background -->

    <div
        class="customer-modal-overlay"
        onclick="closeCustomerModal()"
    ></div>



    <!-- Modal Box -->

    <div class="customer-modal-box">


        <!-- Modal Header -->

        <div class="modal-header">

            <div>

                <span class="modal-label">
                    CUSTOMER MANAGEMENT
                </span>

                <h2>
                    Register Customer
                </h2>

                <p>
                    Enter the customer's information below.
                </p>

            </div>


            <button
                type="button"
                class="modal-close"
                onclick="closeCustomerModal()"
            >
                &times;
            </button>

        </div>



        <!-- =====================================
             VALIDATION ERROR
             ===================================== -->

        <?php

        if (isset($_POST['add'])) {

            if (!empty($errors['surname'])) {

                echo '<p class="error">'
                    . htmlspecialchars($errors['surname'])
                    . '</p>';

            } elseif (!empty($errors['othername'])) {

                echo '<p class="error">'
                    . htmlspecialchars($errors['othername'])
                    . '</p>';

            } elseif (!empty($errors['genderE'])) {

                echo '<p class="error">'
                    . htmlspecialchars($errors['genderE'])
                    . '</p>';

            } elseif (!empty($errors['phoneE'])) {

                echo '<p class="error">'
                    . htmlspecialchars($errors['phoneE'])
                    . '</p>';

            } elseif (!empty($errors['locationE'])) {

                echo '<p class="error">'
                    . htmlspecialchars($errors['locationE'])
                    . '</p>';

            }

        }

        ?>



        <!-- =====================================
             CUSTOMER FORM
             ===================================== -->

        <form
            method="POST"
            action=""
            class="customer-form"
        >

            <div class="form-grid">


                <!-- Surname -->

                <div class="form-group">

                    <label for="Sname">
                        Surname
                    </label>

                    <input
                        type="text"
                        name="Sname"
                        id="Sname"
                        class="input-field"
                        placeholder="Enter surname"
                        value="<?= isset($Sname) ? htmlspecialchars($Sname) : '' ?>"
                        required
                    >

                </div>



                <!-- Other Names -->

                <div class="form-group">

                    <label for="Oname">
                        Othernames
                    </label>

                    <input
                        type="text"
                        name="Oname"
                        id="Oname"
                        class="input-field"
                        placeholder="Enter other names"
                        value="<?= isset($Oname) ? htmlspecialchars($Oname) : '' ?>"
                        required
                    >

                </div>



                <!-- Gender -->

                <div class="form-group">

                    <label for="gender">
                        Gender
                    </label>

                    <select
                        name="gender"
                        id="gender"
                        required
                    >

                        <option
                            value="X"
                            <?= isset($gender) && $gender == 'X' ? 'selected' : '' ?>
                        >
                            -- Select Gender --
                        </option>

                        <option
                            value="M"
                            <?= isset($gender) && $gender == 'M' ? 'selected' : '' ?>
                        >
                            Male
                        </option>

                        <option
                            value="F"
                            <?= isset($gender) && $gender == 'F' ? 'selected' : '' ?>
                        >
                            Female
                        </option>

                    </select>

                </div>



                <!-- Contact -->

                <div class="form-group">

                    <label for="phone">
                        Contact
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        class="input-field"
                        placeholder="Enter contact number"
                        value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>"
                        required
                    >

                </div>



                <!-- Location -->

                <div class="form-group form-full">

                    <label for="location">
                        Location or Residence
                    </label>

                    <input
                        type="text"
                        name="location"
                        id="location"
                        class="input-field"
                        placeholder="Enter location or residence"
                        value="<?= isset($location) ? htmlspecialchars($location) : '' ?>"
                        required
                    >

                </div>

            </div>



            <!-- =====================================
                 FORM BUTTONS
                 ===================================== -->

            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeCustomerModal()"
                >
                    Cancel
                </button>


                <button
                    type="reset"
                    class="clear-btn"
                >
                    Clear
                </button>


                <button
                    type="submit"
                    name="add"
                    class="save-customer-btn"
                >
                    Register Customer
                </button>

            </div>

        </form>

    </div>

</div>



<!-- =========================================
     MODAL JAVASCRIPT
     ========================================= -->

<script>

function openCustomerModal() {

    const modal =
        document.getElementById("customerModal");

    modal.classList.add("active");

    document.body.style.overflow = "hidden";

}


function closeCustomerModal() {

    const modal =
        document.getElementById("customerModal");

    modal.classList.remove("active");

    document.body.style.overflow = "";

}


/* Reopen modal automatically after validation error */

<?php if (isset($_POST['add']) && !empty($errors)) { ?>

openCustomerModal();

<?php } ?>


/* Close modal with ESC */

document.addEventListener("keydown", function(event) {

    if (event.key === "Escape") {

        closeCustomerModal();

    }

});

</script>


</body>

</html>