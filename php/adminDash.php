<?php
require_once 'adminFun.php';
require_once 'dbCon.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Admin Dashboard</title>
</head>

<body>


    <nav class="navbar navbar-light bg-secondary fixed-top shadow-sm">
        <div class="container-lg">
            <a class="navbar-brand text-info fw-bold fs-4" href="#">Admin Dashboard</a>
            <div class="dropdown">
                <button class="btn btn-info px-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    MENU
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a href="contact.html" class="dropdown-item">LogOut</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="contact-messages" class="section-padding py-5 my-4">
        <div class="container-lg card shadow">
        <h2>Messages</h2>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php
                try {
                    // Fetch contact form data
                    $stmt = $pdo->query("SELECT * FROM contact_form");

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $id = $row['id'];
                            $first_name = htmlspecialchars($row['first_name']);
                            $last_name = htmlspecialchars($row['last_name']);
                            $email = htmlspecialchars($row['email']);
                            $created_at = htmlspecialchars($row['created_at']);
                            $comment = htmlspecialchars($row['comment']);
                            $status = htmlspecialchars($row['status']);

                            // Apply the 'text-muted' class if the status is 'read'
                            $dimClass = ($status === 'read') ? 'text-muted' : '';

                            echo '<div class="accordion-item">';
                            echo '<h2 class="accordion-header" id="flush-heading' . $id . '">';
                            echo '<button class="accordion-button collapsed ' . $dimClass . '" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $id . '" aria-expanded="false" aria-controls="flush-collapse' . $id . '">';
                            echo $first_name . ' ' . $last_name . ' (' . $created_at . ')';
                            echo '</button>';
                            echo '</h2>';
                            echo '<div id="flush-collapse' . $id . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $id . '" data-bs-parent="#accordionFlushExample">';
                            echo '<div class="accordion-body">';
                            echo '<p>' . $comment . '</p>';
                            echo '<form method="post" class="d-inline-block me-2">';
                            echo '<input type="hidden" name="message_id" value="' . $id . '">';
                            echo '<button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>';
                            echo '</form>';
                            echo '<button type="button" class="btn btn-primary btn-sm" onclick="copyToClipboard(\'' . $email . '\')">Copy Email</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="accordion-item">';
                        echo '<h2 class="accordion-header">';
                        echo '<button class="accordion-button" type="button" disabled>';
                        echo 'No messages available';
                        echo '</button>';
                        echo '</h2>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>


    <section id="edit-home-section" class="section-padding py-5">
        <div class=" container-lg card shadow px-5 py-4">
            <h2>Edit Home Section</h2>
            <form action="adminDash.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="dev_image" class="form-label">Developer Image</label>
                    <input type="file" class="form-control" id="dev_image" name="dev_image">
                    <img src="<?= $homeData['dev_image']; ?>" alt="Current Image"
                        style="max-height: 100px; margin-top: 10px;">
                </div>
                <div class="mb-3">
                    <label for="dev_name" class="form-label">Developer Name</label>
                    <input type="text" class="form-control" id="dev_name" name="dev_name"
                        value="<?= htmlspecialchars($homeData['dev_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dev_title" class="form-label">Developer Title</label>
                    <input type="text" class="form-control" id="dev_title" name="dev_title"
                        value="<?= htmlspecialchars($homeData['dev_title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dev_intro" class="form-label">Introduction</label>
                    <textarea class="form-control" id="dev_intro" name="dev_intro" rows="3"
                        required><?= htmlspecialchars($homeData['dev_intro']); ?></textarea>
                </div>
                <button type="submit" name="edit_home" class="btn btn-primary">Update Home Section</button>
            </form>
        </div>
    </section>

    <section id="edit-about-section" class="section-padding py-5">
    <div class="container-lg card shadow px-5 py-4">
        <h2>Edit About Section</h2>
        <form action="adminDash.php" method="post">
            <div class="mb-3">
                <label for="heading" class="form-label">Section Heading</label>
                <input type="text" class="form-control" id="heading" name="heading" value="<?= htmlspecialchars($aboutData['heading']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($aboutData['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="project_count" class="form-label">Projects Completed</label>
                <input type="number" class="form-control" id="project_count" name="project_count" value="<?= htmlspecialchars($aboutData['project_count']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="client_count" class="form-label">Happy Clients</label>
                <input type="number" class="form-control" id="client_count" name="client_count" value="<?= htmlspecialchars($aboutData['client_count']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="review_count" class="form-label">Positive Reviews</label>
                <input type="number" class="form-control" id="review_count" name="review_count" value="<?= htmlspecialchars($aboutData['review_count']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cv_link" class="form-label">CV Link</label>
                <input type="url" class="form-control" id="cv_link" name="cv_link" value="<?= htmlspecialchars($aboutData['cv_link']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="facebook_link" class="form-label">Facebook Link</label>
                <input type="url" class="form-control" id="facebook_link" name="facebook_link" value="<?= htmlspecialchars($aboutData['facebook_link']); ?>">
            </div>
            <div class="mb-3">
                <label for="linkedin_link" class="form-label">LinkedIn Link</label>
                <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="<?= htmlspecialchars($aboutData['linkedin_link']); ?>">
            </div>
            <div class="mb-3">
                <label for="instagram_link" class="form-label">Instagram Link</label>
                <input type="url" class="form-control" id="instagram_link" name="instagram_link" value="<?= htmlspecialchars($aboutData['instagram_link']); ?>">
            </div>
            <div class="mb-3">
                <label for="twitter_link" class="form-label">Twitter Link</label>
                <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="<?= htmlspecialchars($aboutData['twitter_link']); ?>">
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">Skills (JSON format)</label>
                <textarea class="form-control" id="skills" name="skills" rows="5" required><?= htmlspecialchars($aboutData['skills']); ?></textarea>
            </div>
            <button type="submit" name="edit_about" class="btn btn-primary">Update About Section</button>
        </form>
    </div>
</section>
<section id="edit-services-section" class="section-padding py-5">
    <div class="container-lg card shadow px-5 py-4">
        <h2>Manage Services</h2>

        <!-- Form for Adding/Editing Service -->
        <form action="adminDash.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="service_icon" class="form-label">Service Icon</label>
                <input type="file" class="form-control" id="service_icon" name="service_icon">
            </div>
            <div class="mb-3">
                <label for="service_title" class="form-label">Service Title</label>
                <input type="text" class="form-control" id="service_title" name="service_title" required>
            </div>
            <div class="mb-3">
                <label for="service_description" class="form-label">Service Description</label>
                <textarea class="form-control" id="service_description" name="service_description" rows="3" required></textarea>
            </div>
            <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
        </form>

        <!-- Display Existing Services with Edit and Delete Options -->
        <h3 class="mt-5">Existing Services</h3>
        <ul class="list-group">
            <?php
            // Fetch existing services
            $stmt = $pdo->query("SELECT * FROM services");
            while ($service = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($service['service_title']); ?>
                    <div>
                        <form action="adminDash.php" method="post" class="d-inline">
                            <input type="hidden" name="service_id" value="<?= $service['serviceID']; ?>">
                            <button type="submit" name="edit_service" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                        <form action="adminDash.php" method="post" class="d-inline">
                            <input type="hidden" name="service_id" value="<?= $service['serviceID']; ?>">
                            <button type="submit" name="delete_service" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</section>

<section id="edit-portfolio-section" class="section-padding py-5">
    <div class="container-lg card shadow px-5 py-4">
        <h2>Edit Portfolio Section</h2>

        <!-- Add New Project Form -->
        <form action="adminDash.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="project_name" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="project_name" name="project_name" required>
            </div>
            <div class="mb-3">
                <label for="project_image" class="form-label">Project Image</label>
                <input type="file" class="form-control" id="project_image" name="project_image" required>
            </div>
            <div class="mb-3">
                <label for="project_link" class="form-label">Project Link</label>
                <input type="url" class="form-control" id="project_link" name="project_link" required>
            </div>
            <button type="submit" name="add_project" class="btn btn-primary">Add Project</button>
        </form>

        <!-- Display Existing Projects -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Project Image</th>
                    <th>Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch existing projects
                $stmt = $pdo->query("SELECT * FROM portfolio ORDER BY created_at DESC");
                $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($projects as $project):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($project['project_name']); ?></td>
                        <td><img src="<?= htmlspecialchars($project['project_image']); ?>" style="max-height: 50px;"></td>
                        <td><a href="<?= htmlspecialchars($project['project_link']); ?>" target="_blank">Live Demo</a></td>
                        <td>
                            <form action="editProject.php" method="post" style="display:inline;">
                                <input type="hidden" name="projectID" value="<?= $project['projectID']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                            </form>
                            <form action="adminDash.php" method="post" style="display:inline;">
    <input type="hidden" name="project_id" value="<?= $project['projectID']; ?>">
    <button type="submit" name="delete_project" class="btn btn-danger btn-sm" >Delete</button>
</form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<section id="edit-testimonials-section" class="section-padding py-5">
    <div class="container-lg card shadow px-5 py-4">
        <h2>Edit Testimonials Section</h2>

        <!-- Add New Testimonial Form -->
        <form action="adminDash.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" required>
            </div>
            <div class="mb-3">
                <label for="testimonial_text" class="form-label">Testimonial</label>
                <textarea class="form-control" id="testimonial_text" name="testimonial_text" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5)</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
            </div>
            <button type="submit" name="add_testimonial" class="btn btn-primary">Add Testimonial</button>
        </form>

        <!-- Display Existing Testimonials -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Testimonial</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch existing testimonials
                $stmt = $pdo->query("SELECT * FROM testimonials ORDER BY created_at DESC");
                $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($testimonials as $testimonial):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($testimonial['name']); ?></td>
                        <td><?= htmlspecialchars($testimonial['position']); ?></td>
                        <td><?= htmlspecialchars($testimonial['testimonial_text']); ?></td>
                        <td><?= htmlspecialchars($testimonial['rating']); ?></td>
                        <td>
                            <form action="editTestimonial.php" method="post" style="display:inline;">
                                <input type="hidden" name="testimonialID" value="<?= $testimonial['testimonialID']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                            </form>
                            <form action="adminDash.php" method="post" style="display:inline;">
    <input type="hidden" name="testimonial_id" value="<?= $testimonial['testimonialID']; ?>">
    <button type="submit" name="delete_testimonial" class="btn btn-danger btn-sm">Delete</button>
</form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>



    <!-- Toast Notification for Copying Email -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Email address copied to clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

<!-- Toast Notification for Message Deletion -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="messageDeleteToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Message deleted successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Toast Notification for Project Deletion -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="projectDeleteToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Project deleted successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Toast Notification for Testimonial Deletion -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="testimonialDeleteToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Testimonial deleted successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script>
        // Function to copy email to clipboard
        function copyToClipboard(email) {
            navigator.clipboard.writeText(email).then(
                function () {
                    showCopyToast(); // Show toast notification on success
                },
                function (err) {
                    console.error("Failed to copy email: ", err);
                }
            );
        }

        // Function to show the copy toast notification
        function showCopyToast() {
            var toastElement = document.getElementById("copyToast");
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    // Function to show the toast notification based on URL parameters
    function showToast(toastId) {
        var toastElement = document.getElementById(toastId);
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    }

    // Check URL for toast parameter and show corresponding toast
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('toast')) {
        var toastType = urlParams.get('toast');
        if (toastType === 'messageDeleted') {
            showToast('messageDeleteToast');
        } else if (toastType === 'projectDeleted') {
            showToast('projectDeleteToast');
        } else if (toastType === 'testimonialDeleted') {
            showToast('testimonialDeleteToast');
        }
    }
    </script>
</body>

</html>