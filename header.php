<?php include_once('head.php'); ?>

<div xmlns="http://www.w3.org/1999/html">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
        <!-- Brand/logo -->
        <div class="container">
            <a class="navbar-brand" href="/landingPage">
                <span id="logo">VIKAR <span class="red">WORK</span></span>
            </a>

            <!-- Links -->
            <ul class="navbar-nav mr-5">
                <li class="nav-item">
                    <a class="nav-link" href="/landingPage">Forside</a>
                </li>

                <li class="nav-item">

                    <a class="nav-link" href="/inbox">
                        <i class="far fa-comment"></i>

                        <span id="countNotification" th:text="${numNotifications}"></span>
                    </a>
                </li>

                <li class="nav-item">
                    <form action="/" th:action="@{/search}" method="post" class="form-inline" id="search_form">
                        <input type="text" th:name="searchJob" placeholder="Søg..." class="form-control mr-2">
                        <button class="btn btn-primary" type="submit">Søg</button>
                    </form>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbardrop" href="#">Bruger Menu</a>
                    <div class="dropdown-menu">
                        <a href="/log_out" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Log af</a>
                        <a href="/settings" class="dropdown-item"><i class="fas fa-user-edit"></i> Rediger oplysninger</a>
                        <a th:if="@{${loginType == 'w'}}" th:href="@{/showProfile}" class="dropdown-item"><i class="fas fa-address-card"></i> Se bruger oplysninger og CV</a>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</div>
<a href="../normalUser/generalFunctions/signout.php">Sign out</a>
