<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<style>
    body{
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f5f5f5;
    color: #333;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

header {
    background: #333;
    color: #fff;
    padding: 20px 0;
    border-bottom: #FF2D20 3px solid;
    position: relative;
}

header h1 {
    margin: 0;
    padding-left: 20px;
}

header nav {
    float: right;
    margin-top: 10px;
}

header nav ul {
    list-style: none;
    padding: 0;
}

header nav ul li {
    display: inline;
    margin: 0 10px;
}

header nav ul li a {
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 16px;
    transition: color 0.3s;
}

header nav ul li a:hover {
    color: #FF2D20;
}

header nav .auth-nav {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    position: absolute;
    right: 20px;
    top: 20px;
}

header nav .auth-nav a {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    background: #FF2D20;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease-in-out;
}

header nav .auth-nav a:hover {
    background: #fff;
    color: #FF2D20;
    box-shadow: 0 0 10px #FF2D20;
}

section {
    padding: 20px 0;
    border-bottom: #eaeaea 1px solid;
}

#home {
    background: #fff;
    text-align: center;
    padding: 50px 0;
}

#home h2 {
    margin: 0;
    padding: 20px 0;
}

#searchForm input[type="text"] {
    width: 70%;
    padding: 15px;
    margin: 20px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#searchForm button {
    padding: 15px 20px;
    background: #FF2D20;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s, box-shadow 0.3s;
}

#searchForm button:hover {
    background: #e0261c;
    box-shadow: 0 0 10px #FF2D20;
}

#about, #services, #contact {
    background: #f5f5f5;
    text-align: center;
    padding: 50px 0;
}

#about h2, #services h2, #contact h2 {
    margin-bottom: 20px;
}

#services ul {
    list-style: none;
    padding: 0;
}

#services ul li {
    background: #fff;
    margin: 5px 0;
    padding: 10px;
    border: #eaeaea 1px solid;
    border-radius: 5px;
}

#contactForm input[type="text"],
#contactForm input[type="email"],
#contactForm textarea {
    width: 80%;
    padding: 15px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#contactForm button {
    padding: 15px 20px;
    background: #FF2D20;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s, box-shadow 0.3s;
}

#contactForm button:hover {
    background: #e0261c;
    box-shadow: 0 0 10px #FF2D20;
}

footer {
    text-align: center;
    padding: 20px 0;
    background: #333;
    color: #fff;
}


</style>
<body>
    <header>
        <div class="container">
            <h1>Welcome to Hostel Management System</h1>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="rooms" target="blank">Rooms</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            @if (Route::has('login'))
                <nav class="auth-nav">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ url('/login') }}"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </a>
    
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>
    
    
    <section id="home">
        <div class="container">
            <h2>Find the Perfect Hostel for You</h2>
            <form id="searchForm">
                <input type="text" id="searchInput" placeholder="Enter location...">
                <button type="submit">Search</button>
            </form>
        </div>
    </section>
    
    <section id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>We offer the best hostels with modern amenities, ensuring comfort and convenience for all our guests.</p>
        </div>
    </section>
    
    <section id="services">
        <div class="container">
            <h2>Our Services</h2>
            <ul>
                <li>Online Booking</li>
                <li>Room Service</li>
                <li>Free Wi-Fi</li>
                <li>24/7 Support</li>
            </ul>
        </div>
    </section>
    
    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form id="contactForm">
                <input type="text" id="name" placeholder="Your Name" required>
                <input type="email" id="email" placeholder="Your Email" required>
                <textarea id="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <p>&copy; 2024 Hostel Management System. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="script.js"></script>
</body>
</html>
