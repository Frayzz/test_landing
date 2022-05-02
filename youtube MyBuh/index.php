<?php

// API config 
$API_Key    = 'AIzaSyDmPgLzIRsMotbWN0Nb3Yl0D9j5kq4INpo'; 
$Channel_ID = 'UCw7YSj6huoUGSedV8eYD5PA'; 
$Max_Results = 15; 
 
// Get videos from channel by YouTube Data API 
$apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$Channel_ID.'&maxResults='.$Max_Results.'&key='.$API_Key.''); 


if($apiData){ 
    $videoList = json_decode($apiData);    
    if(!empty( $videoList -> items )){ 
        foreach( $videoList -> items  as  $item ){ 
            // Встроить видео 
            if(isset( $item -> id -> videoId )){ 

                $twenty_videos['ALL'][$item -> id -> videoId]['HREF'] = '<img src="'. $item -> snippet -> thumbnails -> medium -> url.'" alt="">';
                $twenty_videos['ALL'][$item -> id -> videoId]['IMG'] = '<iframe width="280" height="150" src="https://www.youtube.com/embed/' . $item -> id -> videoId . '" frameborder="0 "allowfullscreen></iframe>';
            } 
        } 
    }else{ 
        echo  '<p class="error">' . $apiError . '</p>' ; 
    }
}else{ 
    echo 'Invalid API key or channel ID.'; 
}




$i = 0;
$name = 'Rewt';
foreach ($twenty_videos['ALL'] as $value) {
    $i++;
    if ($i != 4) {
        $last_publicate['LIST'][$name][$i][] = $value['IMG'];
        $last_publicate['LIST'][$name][$i][] = $value['HREF'];
    } else {
        $i = 0;
        $bytes = openssl_random_pseudo_bytes(4);
        $name = bin2hex($bytes);
    }
    
}

/*
echo '<pre>';
print_r($last_publicate);
echo '</pre>';
*/
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBuh.kz</title>

    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="content">
        <h3><span>Новые</span> видео на Youtube</h3>
        <p>Не пропусти всё самое интересное на нашем канале!</p>
        <hr>
    </div>
    <a class="prev" onclick="minusSlide()"><img src="img/icon_arrow_gray_left.png" alt=""></a>
    <a class="next" onclick="plusSlide()"><img src="img/icon_arrow_gray_right.png" alt=""></a>
    <div class="slider">
        <? $i = 0; foreach( $last_publicate['LIST'] as $item ): ?>
        <div class="item flex_box">
            <div class="three_videos_block">
                <?=$item[1][0]?>
            </div>
            <div class="three_videos_block">
                <?=$item[2][0]?>
            </div>
            <div class="three_videos_block">
                <?=$item[3][0]?>
            </div>
        </div>
        <? endforeach; ?>
    </div>

    <div class="slider-dots">
        <span class="slider-dots_item" onclick="currentSlide(1)"><div class="dots_item_red" onclick="currentSlide(1)"></div></span> 
        <span class="slider-dots_item" onclick="currentSlide(2)"></span> 
        <span class="slider-dots_item" onclick="currentSlide(3)"></span>
        <span class="slider-dots_item" onclick="currentSlide(4)"></span> 
    </div>

</body>
<script>
    /* Индекс слайда по умолчанию */
    var slideIndex = 1;
    showSlides(slideIndex);

    /* Функция увеличивает индекс на 1, показывает следующй слайд*/
    function plusSlide() {
        showSlides(slideIndex += 1);
    }

    /* Функция уменьшяет индекс на 1, показывает предыдущий слайд*/
    function minusSlide() {
        showSlides(slideIndex -= 1);  
    }

    /* Устанавливает текущий слайд */
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    /* Основная функция слайдера */
    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("item");
        var dots = document.getElementsByClassName("slider-dots_item");
        if (n > slides.length) {
        slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        slides[slideIndex - 1].style.display = "flex";
        dots[slideIndex - 1].className += " active";
    }
</script>
</html>