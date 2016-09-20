<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=editors'));
    }
	$category_id=0;
	if ( isset($_GET['category_id'])) {
		$category_id=$_GET['category_id'];
	}
	if(isset($_POST['editBtn'])){
		$sub = $_POST['editBtn'];
		if($sub=="add"){
			if (isset($_POST['not_editor']) && is_array($_POST['not_editor'])) {
				foreach ($_POST['not_editor'] as $user) {
					$user = ($user * 1); // quick int convertion
					$query = "INSERT INTO category_editors VALUES($user, $category_id )";
					mysqli_query($database_link, $query) or die(mysqli_error($database_link));
				}
			}
		}else if($sub=="del"){
			if (isset($_POST['is_editor']) && is_array($_POST['is_editor'])) {
				foreach ($_POST['is_editor'] as $user) {
					$user = ($user * 1); // quick int convertion
					$query = "DELETE FROM category_editors WHERE fk_users_id = $user AND fk_categories_id = $category_id";
					mysqli_query($database_link, $query) or die(mysqli_error($database_link));
				}
			}
		}
	}


?>

<h2>Redaktør Administration</h2>
<div class="panel panel-info">


	<p class="panel-heading">
		Dette skal du lave :)
	</p>

	<form method="post">
	<p class="panel-body">
		<select class="form‐control" name="category_id" onchange="location = this.options[this.selectedIndex].value;">
			<option value="index.php?page=editors">Vælg Kategori</option>
			<?php
			$query = "SELECT category_id,category_title FROM categories";// 3 == redaktør
			$result = mysqli_query($database_link, $query) or die(mysqli_error($database_link));
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<option value="index.php?page=editors&category_id='.$row['category_id'].'" '.($category_id==$row['category_id'] ? 'selected' : '').'>'.$row['category_title'].'</option>';
			}
			?>
		</select>
		<?php if($category_id !== 0){?>
		<ul class="editors_list">
			<li>
				<h3>Ikke Redaktører</h3>
				<select class="form‐control" name="not_editor[]" multiple="multiple" size="20">
					<?php
						$query = "SELECT user_id, user_name FROM users WHERE user_id NOT IN ( SELECT fk_users_id FROM category_editors WHERE fk_categories_id = $category_id) AND fk_roles_id = 3";// 3 == redaktør
						$result = mysqli_query($database_link, $query) or die(mysqli_error($database_link));
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="midbuttons">
				<button type="submit" name="editBtn" value="add">>></button>
				<button type="submit" name="editBtn" value="del"><<</button>
			</li>
			<li>
				<h3>Redaktører</h3>
				<select class="form‐control" name="is_editor[]" multiple="multiple" size="20">
					<?php
						$query = "SELECT user_id, user_name FROM users INNER JOIN category_editors ON fk_users_id = user_id WHERE fk_categories_id = $category_id AND fk_roles_id = 3";// 3 == redaktør
						$result = mysqli_query($database_link, $query) or die(mysqli_error($database_link));
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
						}
					?>
				</select>
			</li>

		</ul>
		<?php }?>
	</div>
	</form>

</div>


