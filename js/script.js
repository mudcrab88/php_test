window.onload = function() {
    form = document.getElementById("user_register_form");
	form.onsubmit = function() {
		error = document.getElementById("error");
		photo_type = document.getElementById("photo").files[0].type;
		if (photo_type =="image/jpeg"||photo_type =="image/png"){
			return true;
		} else {
			error.innerHTML = "Формат фотографии неверный";
			return false;
		}
	};
  };
  