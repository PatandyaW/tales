<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	<div class="content-wrapper">
  <div class="container">
  <section class="content">
		<div class="row">
	  	<div class="col-sm-9">
	  
		  <div class="row">
				<div class="col-md-12 mt-5 text-center">
					<h2>Plan-net</h2>
					<form action="" method="post">
						<input type="text" class="form-control" name="q" placeholder="Ask Anything About Plants">
					</form>
				
					<div class='row'>
					<div class='col-md-12'>
	       								<div class='box box-solid'>
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
            
            echo $decode['choices'][0]['text'];
        }
        ?>
		
    </div>
    </div>
    </div>
    </div>
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
			<div class="col-sm-3">
    <?php include 'includes/sidebar.php'; ?>
</div>

		
			</section>
	    </div>
	</div>
	<?php include 'includes/footer.php'; ?>
			</div>
			
			<?php include 'includes/scripts.php'; ?>
			</body>
			
</html>


