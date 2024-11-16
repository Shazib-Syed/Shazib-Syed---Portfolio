<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shazib Syed - Portfolio</title> 
    <!-- Tailwindcss link -->
    <link href="dist/output.css" rel="stylesheet">
    <!-- Alpine js link -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- font-awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-custom-bg font-sans">
<header class="bg-cms-bg shadow-md">  
        <nav class="container mx-auto px-6 py-3">
            <ul class="flex justify-end space-x-8">
                <li><a href="#intro" class="text-custom-text hover:text-blue-200">Home</a></li>
                <li><a href="#projects" class="text-custom-text hover:text-blue-200">Projects</a></li>
                <li><a href="#contact" class="text-custom-text hover:text-blue-200">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        <!-- Introductie Section -->
        <section id="intro" class="container mx-auto px-1 py-16">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl text-custom-text font-bold mb-4">Shazib Syed</h1>
                    <p class="text-xl text-custom-text mb-4">Web Developer</p>
                    <p class="text-custom-text">Hello! I’m a software developer currently studying at the Bit Academy in Amsterdam, with a strong interest in backend development and a passion for building functional, user-friendly web applications. I’m currently working on a PHP project called Weather Scraper and enhancing my skills in Laravel. My core expertise includes HTML, CSS, PHP, and MySQL, and I’m dedicated to creating websites that are both visually appealing and efficient. Feel free to reach out to me at syedshahm20@gmail.com or through the contact form below.</p>  
                </div>
                <div class="md:w-1/2">
                    <img src="profile-picture/myprofilepic.png" alt="Shazib Syed" class="rounded-full mx-auto" width="300" height="300">
                </div>
            </div>
        </section>
        <!-- Project Overview Section -->
        <section id="projects" class="mb-12" x-data="{ projects: [] }" x-init="fetch('get_projects.php').then(response => response.json()).then(data =>   projects = data)">
            <h2 class="text-3xl text-custom-text font-bold mb-8">My Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="project in projects" :key="project.id">
                    <div class="bg-cms-bg rounded-lg shadow-md overflow-hidden">
                        <img :src="'CMS/' + project.image" :alt="project.title" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl text-custom-text font-semibold mb-2" x-text="project.title"></h3>
                            <p class="text-custom-text mb-4" x-text="project.description"></p>
                            <a :href="project.live_url" target="_blank" rel="noopener noreferrer" class="inline-block bg-custom-button text-custom-bg px-4 py-2 rounded hover:bg-blue-200 transition-colors mt-4">
                            GitHub Link
                            </a>
                        </div>
                    </div>
                </template>
            </div>
            
        </section>
    <!-- Contact Form -->
        <section id="contact" class="mb-12">
            <h2 class="text-2xl text-custom-text font-bold mb-6">Contact Me</h2>
            <form id="contactForm" class="max-w-lg">
                <div class="mb-4">
                    <label for="name" class="block text-custom-text  font-bold mb-4">Name</label>
                    <input type="text" id="name" name="name" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-custom-text  font-bold mb-4">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-custom-text  font-bold mb-4">Message</label>
                    <textarea id="message" name="message" required class="w-full px-3 py-2 border rounded-lg" rows="4"></textarea>
                </div>
                <button type="submit" class="bg-custom-button text-custom-bg px-4 py-2 rounded hover:bg-blue-200 transition-colors">Send</button>
            </form>
            <div id="formMessage" class="mt-4"></div>
        </section>
    </main>
    <!-- footer -->
    <footer class="bg-cms-bg text-custom-text py-6">
        <div class="container mx-auto px-6">
            <div class="flex justify-center space-x-6">
                <a href="#" class="hover:text-blue-200"><i class="fab fa-twitter"></i><span class="sr-only">Twitter</span></a>
                <a href="https://www.linkedin.com/in/shazib-ahmad/" class="hover:text-blue-200"><i class="fab fa-linkedin"></i><span class="sr-only">LinkedIn</span></a>
                <a href="https://github.com/Shazib-Syed" class="hover:text-blue-200"><i class="fab fa-github"></i><span class="sr-only">GitHub</span></a>
                <a href="#" class="hover:text-blue-200"><i class="fab fa-instagram"></i><span class="sr-only">Instagram</span></a>
            </div>
            <p class="mt-4 text-center">&copy; 2024 Shazib Syed. All rights reserved.</p>
        </div>
    </footer>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            fetch('submit_form.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                var messageElement = document.getElementById('formMessage');
                if (data.success) {
                    messageElement.textContent = data.message;
                    messageElement.className = 'mt-4 text-green-600';
                    this.reset();
                } else {
                    messageElement.textContent = data.message;
                    messageElement.className = 'mt-4 text-red-600';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                var messageElement = document.getElementById('formMessage');
                messageElement.textContent = 'An error occurred. Please try again later.';
                messageElement.className = 'mt-4 text-red-600';
            });
        });
    </script>
</body>
</html>