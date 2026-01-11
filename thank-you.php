<?php include('includes/header.php'); ?>

<div class="thank_you_page">
    <div class="container">
        <div class="inner_container">

            <div class="heading">Thank
                You<?php echo isset($_SESSION['order_details']['name']) ? ', ' . htmlspecialchars($_SESSION['order_details']['name']) : ''; ?>
            </div>
            <div class="sub_heading">We have received your details</div>
            <?php if (isset($_SESSION['order_details']['payment_id'])): ?>
                <p style="color: #fff;">Transaction ID:
                    <?php echo htmlspecialchars($_SESSION['order_details']['payment_id']); ?></p>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>