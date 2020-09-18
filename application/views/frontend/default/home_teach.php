<section class="home-banner-area teach-banner-area" >
    <div class="container-lg">
        <div class="row">
            <!-- <div class="col"> -->
            <div class="mx-auto ab-header-card" > <!-- new -->
                <div class="home-banner-wrap">
                    <h2><?php echo site_phrase('Make_a_global_impact'); ?></h2>
                    <p><?php echo site_phrase('Create_an_online_video_course_and_earn_money_by_teaching_people_around_the_world.'); ?></p>
                    <a href="#" class="btn" id="ab-btn-red">Become an instructor</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ab-discover-section">
  <div class="container-lg">
    <div class="row">
      <div class="container">

                <div class="text-center" id="ab-full-width">
                  <h4 class="ab-heading-1">Discover your potential</h4>
                </div>

                <div class="ab-potentials">

                  <div class="ab-potentials-each">
                    <img src="http://localhost/skillcentral2/uploads/system/salary.png" alt="">
                    <h6 class="ab-heading-2 my-3">Earn money</h6>
                    <p class="ab-paragraph-1">Earn money every time a student purchases your course. Get paid monthly through PayPal or Payoneer, it’s your choice.</p>
                  </div>

                  <div class="ab-potentials-each">
                    <img src="http://localhost/skillcentral2/uploads/system/innovation.png" alt="">
                    <h6 class="ab-heading-2 my-3">Inspire students</h6>
                    <p class="ab-paragraph-1">Help people learn new skills, advance their careers, and explore their hobbies by sharing your knowledge.</p>
                  </div>

                  <div class="ab-potentials-each">
                    <img src="http://localhost/skillcentral2/uploads/system/meeting.png" alt="">
                    <h6 class="ab-heading-2 my-3">Join our community</h6>
                    <p class="ab-paragraph-1">Take advantage of our active community of instructors to help you through your course creation process.</p>
                  </div>

                </div>
      </div>

      </div>
    </div>
  </div>
</section>

<section class="ab-stats-section">
  <div class="container-lg">
    <div class="row">
      <div class="container">

                <div class="text-center" id="ab-full-width">
                  <h4 class="ab-heading-1 color-white">Exceptional opportunities</h4>
                </div>

                <div class="ab-stats">
                  <div class="ab-stats-each">
                    <h3 class="ab-heading-3">50m</h3>
                    <p class="ab-paragraph-2">Students worldwide</p>
                  </div>

                  <div class="ab-stats-each">
                    <h3 class="ab-heading-3">65+</h3>
                    <p class="ab-paragraph-2">Different languages</p>
                  </div>

                  <div class="ab-stats-each">
                    <h3 class="ab-heading-3">295m</h3>
                    <p class="ab-paragraph-2">Course enrollments</p>
                  </div>

                  <div class="ab-stats-each">
                    <h3 class="ab-heading-3">190+</h3>
                    <p class="ab-paragraph-2">Countries taught</p>
                  </div>

                  <div class="ab-stats-each">
                    <h3 class="ab-heading-3">5,000+</h3>
                    <p class="ab-paragraph-2">Enterprise Customers</p>
                  </div>
                </div>
      </div>

      </div>
    </div>
  </div>
</section>


<section class="ab-instructor-section">
  <div class="container-lg">
    <div class="row">
      <div class="container text-center">

        <h3 class="ab-heading-4">Become an instructor today</h3>
        <p class="ab-paragraph-3 my-4">Join the world's largest online learning marketplace.</p>
        <a href="#" class="btn"> Get started </a>

      </div>
      </div>
    </div>
  </div>
</section>


<script type="text/javascript">
function handleWishList(elem) {

    $.ajax({
        url: '<?php echo site_url('home/handleWishList');?>',
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                if ($(elem).hasClass('active')) {
                    $(elem).removeClass('active')
                }else {
                    $(elem).addClass('active')
                }
                $('#wishlist_items').html(response);
            }
        }
    });
}

function handleCartItems(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
            if ($(elem).hasClass('addedToCart')) {
                $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('add_to_cart'); ?>");
            }else {
                $('.big-cart-button-'+elem.id).addClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('added_to_cart'); ?>");
            }
            $.ajax({
                url: url2,
                type : 'POST',
                success: function(response)
                {
                    $('#wishlist_items').html(response);
                }
            });
        }
    });
}

function handleEnrolledButton() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn');?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }
        }
    });
}
</script>
