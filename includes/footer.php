

</div>
<!-- main -->

<footer>
    <div class="heart heart_1"><img src="images/heart.png"></div>
    <div class="contain_90">
        <div class="inner_container">
            
            <div class="price_band  fade-in-up-footer">
                <img src="images/price-band.webp">
            </div>
            <div class="offer_valid  fade-in-up-footer">Offer valid until January 31st, 2026</div>
            <div class="includes_premium  fade-in-up-footer">Includes premium packaging + book + pop-up message</div>
            <div class="order_now  fade-in-up-footer">Order Now | Gift Love Today</div>
            <div class="c2a_btn">
                <!-- <a href="https://pages.razorpay.com/pl_RpW0MZFEEk42FD/view" target="_blank" class="pink_btn heartBeat"> -->
                <a href="checkout.php" class="pink_btn heartBeat">
                    <span>Pre-Book Now</span>
                    <span class="hollow_heart"><img src="images/hollow-heart.svg"></span>
                </a>
            </div>
            <div class="last_text  fade-in-up-footer">Limited Valentine’s Edition.<br>
                Position with Poems<br>
                Turning Moments into Masterpieces Magically.</div>

        </div>
    </div>
</footer>



<!--sticky header-->
<script src="js/classie.js" type="text/javascript"></script>
<script>
function init() {
window.addEventListener('scroll', function(e){
  var distanceY = window.pageYOffset || document.documentElement.scrollTop,
  shrinkOn = 50,
  header = document.querySelector("header");
  if (distanceY > shrinkOn) {
  classie.add(header,"smaller");
  } else {
  if (classie.has(header,"smaller")) {
    classie.remove(header,"smaller");
  }
  }
});
}
window.onload = init();
</script>
<script type="text/javascript" src="js/common.js"></script>
<script src='js/jquery.easing.1.3.js'></script>


<script src="js/ace-responsive-menu.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#respMenu").aceResponsiveMenu({
        resizeWidth: '768', // Set the same in Media query       
        animationSpeed: 'fast', //slow, medium, fast
        accoridonExpAll: false //Expands all the accordion menu on click
    });

     // Tab
    $('ul.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });

    $('ul.cs_tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
        console.log("inside second tab");
        $('ul.cs_tabs li').removeClass('active');
        $('.cs-tab-content').removeClass('active');

        $(this).addClass('active');
        $("#"+tab_id).addClass('active');
    });
});
</script>

<!-- <script type="text/javascript" src="venobox/venobox.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  /* default settings */
  $('.venobox').venobox({
    framewidth: '500px', 
  }); 
});
</script> -->


<script src='js/wow.min.js'></script>
<script>
new WOW().init();
</script>

<!--slider-->
<script src="owl-carousel/owl.carousel.js"></script>
<script src="owl-carousel/owl-content-animation.js"></script>


<!-- GSAP core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<!-- ScrollTrigger plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<script src="js/custom.js"></script>

</body>
</html>
