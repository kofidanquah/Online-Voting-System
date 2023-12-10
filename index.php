<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    /* Theming */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"); /* import font */

:root{
    --white: #f9f9f9;
    --black: #36383F;
    --gray: #85888C;
} /* variables*/

/* Reset */
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    background-color: var(--white);
    font-family: "Poppins", sans-serif;
}
a{
    text-decoration: none;
}
ul{
    list-style: none;
}

/* Header */
.header{
    background-color: var(--black);
    box-shadow: 1px 1px 5px 0px var(--gray);
    position: sticky;
    top: 0;
    width: 100%;
}
/* Logo */
.logo{
    display: inline-block;
    color: var(--white);
    font-size: 60px;
    margin-left: 10px;
}

/* Nav menu */
.nav{
    width: 100%;
    height: 100%;
    position: fixed;
    background-color: var(--black);
    overflow: hidden;
    max-height: 0;
    transition: max-height .5s ease-out;


}
.menu a{
    display: block;
    padding: 30px;
    color: var(--white);
}
.menu a:hover{
    background-color: var(--gray);
}
/* .nav{
} */
/* Menu Icon */
.hamb{
    cursor: pointer;
    float: right;
    padding: 40px 20px;
}/* Style label tag */

.hamb-line {
    background: var(--white);
    display: block;
    height: 2px;
    position: relative;
    width: 24px;

} /* Style span tag */

.hamb-line::before,
.hamb-line::after{
    background: var(--white);
    content: '';
    display: block;
    height: 100%;
    position: absolute;
    transition: all .2s ease-out;
    width: 100%;
}
.hamb-line::before{
    top: 5px;
}
.hamb-line::after{
    top: -5px;
}

.side-menu {
    display: none;
} /* Hide checkbox */

/* Toggle menu icon */
.side-menu:checked ~ nav{
    max-height: 40%;
}
.side-menu:checked ~ .hamb .hamb-line {
    background: transparent;
}
.side-menu:checked ~ .hamb .hamb-line::before {
    transform: rotate(-45deg);
    top:0;
}
.side-menu:checked ~ .hamb .hamb-line::after {
    transform: rotate(45deg);
    top:0;
}
img {
    width: 100%;
    height: 550px;
}

/* Responsiveness */
@media (min-width: 768px) {
    .nav{
        max-height: none;
        top: 0;
        position: relative;
        float: right;
        width: fit-content;
        background-color: transparent;
    }
    .menu li{
        float:left;
    }
    .menu a:hover{
        background-color: transparent;
        color: var(--gray);

    }

    .hamb{
        display: none;
    }
}

a{
    color: var(--black);
}
h4{
    text-align: center;
    color:coral;
    font-family:Arial, Helvetica, sans-serif;
}
footer{
    background-color: rgb(71, 172, 156);
    height: 300px;
    width:100%;
}

ul{
    color: var(--white);
}
#main{
    cursor: pointer;
}

img{cursor: pointer;
    border: 2px solid black;

}


#election {
    border: 1px solid black;
    background-image: url(images/background\ image.jfif);
    background-repeat: no-repeat;
    background-size: cover;
    background-color: antiquewhite;
}
    hr{
    border: 2px solid black;
}
#home:hover{
    color: blue;
}

li:hover{
    color:gray;
    cursor:pointer;
}
</style>

    <title>VT</title>
</head>
<body>
<header class="header">
<!-- Logo -->
<a href="#" class="logo">VT</a>
<!-- Hamburger icon -->
<input class="side-menu" type="checkbox" id="side-menu"/>
<label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
<!-- Menu -->
<nav class="nav">
<ul class="menu">
    <li><a href="#">News</a></li>
    <li><a href="./voter/login.view.php">Log in</a></li>
    <li><a href="#">Contact us</a></li>

</ul>
</nav>
</header>
<nav class="navbar navbar-default container-fluid" style=position:unset >
<div class="container-fluid col-sm-3" >
<a href="#" id=home>HOME</a>

</div>
<div class="container-fluid col-sm-3">
<a href="#" id=home>OUR SERVICES</a>
</div>

<div class="container-fluid col-sm-3">
<a href="#" id=home>ABOUT US</a>
</div>

<div class="container-fluid col-sm-3">
<a href="#" id=home>SUPPORT</a>
</div><br><br>

</nav>
<img src="images/voting.png" id="main"><br><br></br>

<div class="row container-fluid">
<div class=" container-fluid col-sm-6">
<h3> Flawless Elections, made simple.</h3>
</div>


<div class=" container-fluid col-sm-6">
<div>
Over 100 organizations  rely on  VT for their election needs. Our secure protocols, ease-of-use and flexible solutions transform elections across industries. Get in touch with us to learn how we can run your next election together.
</div>
</div>


</div><br><br>
<div class="" id=election>
<h3>
Scheduled Elections
</h3>
Organization----------------------Date
<a><li></li></a>
<a><li></li></a>
<a><li></li></a>
<a><li></li></a>
<a><li></li></a>
<a><li></li></a>

</div><br><br></br>





<h4>INDUSTRIES WE WORK WITH</h4>
<div class="row container-fluid">
<div class="col-sm-4">
<img src="images/church.jpg"  class="img-fluid"alt="industry"><br>
Churches
</div><br>

<div class="col-sm-4">
<img src="images/bank-building1.jpg"  class="img-fluid" alt="industry"><br>
Banks
</div><br>

<div class="col-sm-4">
<img src="images/union.jpg"  class="img-fluid" alt="industry"><br>
Unions/ Associations
</div><br>      

</div>

<div class="row container-fluid">
<div class="col-sm-4">
<img src="images/sch.jpg"  class="img-fluid" alt="industry"><br>
Schools
</div><br>

<div class="col-sm-4">
<img src="images/parl.jpg"  class="img-fluid" alt="industry"><br>
Political Parties
</div><br>

<div class="col-sm-4">
<img src="images/KHQ-10.jpg"  class="img-fluid" alt="industry"><br>
Coperate Organiztions
</div> <br>     

</div><br><br>


<footer>
<div class="container row">
<div class="col-sm-3" >
    <ul>
        <li>Privacy Policy</li>
        <li>Terms of service</li>
        <li>Contact Information</li>
        <li>Partners</li>
    </ul>
</div>

<div class="col-sm-3">
    Quick Links
    <ul>
        <li>Home</li>
        <li>SERVICES</li>
        <li>ABOUT</li>
        <li>SUPPORT</li>
    </ul>
</div>

<div class="col-sm-6">
    <form style=position:end>
        Email us:<br>
        <input type="email" name = "email" placeholder="Email" autocomplete="off"><br>
        <textarea placeholder="Message" cols=35 rows=4></textarea>
        <input type="submit" value="Send">

    </form>
</div>

</div>
</footer>

</body>
</html>