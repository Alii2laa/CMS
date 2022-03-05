<?php session_start() ?>
<?php
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] == 'admin'){
            header("Location: admin/index.php");
        }
    }

?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Press+Start+2P');


    html,body{
        width: 100%;
        height: 100%;
        margin: 0;
    }

    *{
        font-family: 'Press Start 2P', cursive;
        box-sizing: border-box;
    }
    #app{
        padding: 1rem;
        display: flex;
        height: 100%;
        background-color: black;
        justify-content: center;
        align-items: center;
        color: #54FE55;
        text-shadow: 0px 0px 10px ;
        font-size: 3rem;
        flex-direction: column;
    .txt {
        font-size: 1.8rem;
    }
    }
    @keyframes blink {
        0%   {opacity: 0}
        49%  {opacity: 0}
        50%  {opacity: 1}
        100% {opacity: 1}
    }

    .blink {
        animation-name: blink;
        animation-duration: 1s;
        animation-iteration-count: infinite;
    }
</style>
    <div id="app">
        <div style="
    margin-bottom: 18px;">403</div>
        <div class="txt">
            Forbidden Access Not Granted<span class="blink">_</span>
        </div>
    </div>
