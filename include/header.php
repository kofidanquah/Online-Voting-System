<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
/* Theming */

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap");

/* import font */

:root {
    --white: #f9f9f9;
    --black: #36383F;
    --gray: #85888C;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Poppins", sans-serif;
}

a {
    text-decoration: none;
}

ul {
    list-style: none;
}


/* Header */

.header {
    background-color: var(--black);
    position: sticky;
    top: 0;
    width: 100%;
    z-index: 10;
}


/* Logo */

.logo {
    display: inline-block;
    color: var(--white);
    font-size: 60px;
    margin-left: 10px;
}


/* Nav menu */

.nav {
    width: 100%;
    height: 100%;
    position: fixed;
    background-color: var(--white);
    overflow: hidden;
    max-height: 0;
    transition: max-height .5s ease-out;
}

.menu a {
    display: block;
    padding: 30px;
    color: var(--white);
}

.menu a:hover {
    background-color: var(--gray);
}


/* Menu Icon */

.hamb {
    cursor: pointer;
    float: right;
    padding: 40px 20px;
}

.hamb-line {
    background: var(--white);
    display: block;
    height: 2px;
    position: relative;
    width: 24px;
    float:right;
}


/* Style span tag */

.hamb-line::before,
.hamb-line::after {
    background: var(--white);
    content: '';
    display: block;
    height: 100%;
    position: absolute;
    transition: all .2s ease-out;
    width: 100%;
}

.hamb-line::before {
    top: 5px;
}

.hamb-line::after {
    top: -5px;
}

.side-menu {
    display: none;
}


/* Toggle menu icon */

.side-menu:checked~nav {
    max-height: 100vh;
}

.side-menu:checked~.menu a {
    padding: 5px;
}

.side-menu:checked~.hamb .hamb-line {
    background: transparent;
}

.side-menu:checked~.hamb .hamb-line::before {
    transform: rotate(-45deg);
    top: 0;
}

.side-menu:checked~.hamb .hamb-line::after {
    transform: rotate(45deg);
    top: 0;
}

img.partner {
    width: 70%;
    height: 70%;
    cursor: pointer;
}

img.logo {
    width: 100px;
    height: 80px;
    padding: 15px;
}


/* Responsiveness */

@media (min-width: 768px) {
    .nav {
        max-height: 100vh;
        top: 0;
        position: relative;
        float: right;
        width: fit-content;
        background-color: transparent;
    }
    .menu li {
        float: right;
        color:var(--white);
    }
    .menu a:hover {
        background-color: transparent;
        color: var(--gray);
    }
    .hamb {
        display: none;
    }
}
        img.partner {
            width: 70%;
            height: 70%;
            cursor: pointer;
        }

        img.img-responsive {
            width: 70%;
            height: 70%;
            cursor: pointer;
        }

        /* Responsiveness */

        @media (min-width: 768px) {
            .nav {
                max-height: none;
                top: 0;
                position: relative;
                float: right;
                width: fit-content;
                background-color: transparent;
            }

            .menu li {
                float: left;
            }

            .menu a:hover {
                background-color: transparent;
                color: var(--gray);
            }

            .hamb {
                display: none;
            }
        }
    </style>
    <title>header</title>
</head>

<body>
    <header class="header">
        <!-- Logo -->
        <a href="#" class="logo">VT</a>
        <!-- Hamburger icon -->
        <input class="side-menu" type="checkbox" id="side-menu" />
        <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
        <!-- Menu -->
        <nav class="nav">
            <ul class="menu">
                <li><a href=""><i class="fa fa-bell fa-2x"></i></a></li>
                <li><a href=""><i class="fa fa-user-circle-o fa-2x"></i></a></li>
                </li>
            </ul>

        </nav>
    </header>

</body>

</html>