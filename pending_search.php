<?php
include('connection.php');


// Get the search query
$query = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';

$sql = "SELECT
pr.applicant_id,
pr.request_id,
a.fullname,
pr.request_date,
d.file_uploads
FROM applicants a
INNER JOIN permission_requests pr ON a.applicant_id = pr.applicant_id
LEFT JOIN documents d ON pr.file_id = d.file_id
WHERE (a.applicant_id LIKE '%$query%' OR a.fullname LIKE '%$query%' OR a.username LIKE '%$query%') AND pr.status = 'Pending'
ORDER BY pr.request_date DESC";



$result = $conn->query($sql);

// Display search results
if (mysqli_num_rows($result) == 0) {
    echo "<tr>
            <td colspan='5' style='text-align:center; font-weight: bold; color: red'>No Record Found</td>
          </tr>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>{$row['applicant_id']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['file_uploads']}</td>
                <td>{$row['request_date']}</td>
                <td>
                 <a href='accept_request.php?action=accept&request_id= {$row['request_id']}'class='btn btn-success'>Accept</a> 
                 <a href='reject_request.php?action=reject&request_id= {$row['request_id']}' onclick='reject()' class='btn btn-danger'>Reject</a>
                 <td>
                <tr>";
                
               
               
            }
        
        }
    

$conn->close();
?>
<script>
function reject(request_id) {
    if (confirm('Are you sure you want to Decline this Pending Request ?')) {
    window.location.href = "delete_request.php?request_id=" +   request_id;

     // Use the applicantId in the data for the AJAX request
     $.ajax({
            type: 'GET',
            url: 'reject_request.php',
            data: { request_id: applicantId },
            success: function(response) { 
              
                var data = JSON.parse(response);
                console.log(data); // Add this line to log the response
                console.log(applicantId);

                if (data.success) {
                    // Use the applicantId in the redirect URL
                    window.location.href = 'pending_request.php';
                } else {
                    alert('Failed to delete Document.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
            
        });
    }
}

                    
</script>
