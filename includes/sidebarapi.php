<div class="row">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><b>Most Viewed Today</b></h3>
	  	</div>
	  	<div class="box-body">
	  		<ul id="trending">
	  		<?php
	  			$now = date('Y-m-d');
	  			$conn = $pdo->open();

	  			$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
	  			$stmt->execute(['now'=>$now]);
	  			foreach($stmt as $row){
	  				echo "<li><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></li>";
	  			}

	  			$pdo->close();
	  		?>
	    	<ul>
	  	</div>
	</div>
</div>

<div class="row">
<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><b>Curious about our plant?</b></h3>
	  	</div>
            
					<form action="" method="post">
						<input type="text" class="form-control" name="q" placeholder="Ask About Anything">
					</form>
				
					
	       								
                    <div class='box-body prod-body'>
    <?php
    if (isset($_POST['q'])) {
        $query = $_POST['q'];

        $ar = array(
            'prompt' => 'interact as assistant based on this "'.$query.'"',
            'model' => 'text-davinci-003',
            'temperature' => 0,
            'max_tokens' => 160,
            'top_p' => 1,
            'frequency_penalty' => 1,
            'presence_penalty' => 1,
        );

        $data = json_encode($ar);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer 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';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        curl_close($ch);

        $decode = json_decode($result, true);

        echo "<p>".$decode['choices'][0]['text']."</p>";
    }
    ?>

</div>
			</div>
</div>
<script>
    function handleKeyDown(event) {
        if (event.shiftKey && event.keyCode === 13) {
            event.preventDefault();
            var input = event.target;
            var start = input.selectionStart;
            var end = input.selectionEnd;
            var value = input.value;
            input.value = value.substring(0, start) + "\n" + value.substring(end);
            input.selectionStart = input.selectionEnd = start + 1;
        }
    }

    // Prevent form submission on "Shift" + "Enter" key combination
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.querySelector("form");
        form.addEventListener("keydown", function(event) {
            if (event.shiftKey && event.keyCode === 13) {
                event.preventDefault();
            }
        });
    });
</script>


<div class="row">
	<div class='box box-solid'>
	  	<div class='box-header with-border'>
	    	<h3 class='box-title'><b>Follow us on Social Media</b></h3>
	  	</div>
	  	<div class='box-body'>
	    	<a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
	    	<a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
	    	<a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
	    	<a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
	    	<a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
	  	</div>
	</div>
</div>
