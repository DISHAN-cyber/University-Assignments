function changeView() {
    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");


    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

function signup() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var mobile = document.getElementById("mobile");
    var gender = document.getElementById("gender");

    var form = new FormData();
    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("m", mobile.value);
    form.append("g", gender.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                document.getElementById("msg").innerHTML = "Registration Successful";
                document.getElementById("msg").className = "alert alert-success";
                document.getElementById("msgdiv").className = "d-block";
                changeView();
            } else {
                document.getElementById("msg").innerHTML = response;
                document.getElementById("msgdiv").className = "d-block";
            }
        }
    }

    request.open("POST", "signUpProcess.php", true);
    request.send(form);
}

function signIn() {
    var email = document.getElementById("email2");
    var password = document.getElementById("password2");
    var rememberMe = document.getElementById("rememberMe");

    var form = new FormData();
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("r", rememberMe.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                window.location = "home.php";
            } else {
                document.getElementById("msg1").innerHTML = response;
                document.getElementById("msgdiv1").className = "d-block";
            }
        }
    }

    request.open("POST", "signInProcess.php", true);
    request.send(form);
}

var forgotPasswordModal;

function forgotPassword() {

    var email = document.getElementById("email2");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "Success") {
                alert("Verification code has sent successfully to your email");
                var modal = document.getElementById("fpModal");
                forgotPasswordModal = new bootstrap.Modal(modal);
                forgotPasswordModal.show();
            } else {
                document.getElementById("msg1").innerHTML = response;
                document.getElementById("msgdiv1").className = "d-block";
            }
        }
    }

    request.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
    request.send();
}

function showPassword1() {
    var textField = document.getElementById("np");
    var button = document.getElementById("npb");

    if (textField.type == "password") {
        textField.type = "text";
        button.innerHTML = "Hide";
    } else {
        textField.type = "password";
        button.innerHTML = "Show";
    }
}

function showPassword2() {
    var textField = document.getElementById("rp");
    var button = document.getElementById("npb");

    if (textField.type == "password") {
        textField.type = "text";
        button.innerHTML = "Hide";
    } else {
        textField.type = "password";
        button.innerHTML = "Show";
    }
}

function resetPassword() {

    var email = document.getElementById("email2");
    var newPassword = document.getElementById("np");
    var retypedPassword = document.getElementById("rp");
    var verificationCode = document.getElementById("vcode");

    var form = new FormData();
    form.append("e", email.value);
    form.append("np", newPassword.value);
    form.append("rp", retypedPassword.value);
    form.append("vcode", verificationCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {
                alert("Password Updated Successfully");
                forgotPasswordModal.hide();
            }
        }
    }
    request.open("POST", "resetPasswordProcess.php", true);
    request.send(form);

}

function signout() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                window.location.reload();
            }
        }
    }
    request.open("POST", "signOutProcess.php", true);
    request.send();

}

function showPassword3() {
    var pw = document.getElementById("pw");
    var pwi = document.getElementById("pwi");

    if (pw.type == "password") {
        pw.type = "text";
        pwi.className = "bi bi-eye-fill text-white";

    } else {
        pw.type = "password";
        pwi.className = "bi bi-eye-slash-fill text-white";
    }
}

function selectDistrict() {

    var province_id = document.getElementById("province").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("district").innerHTML = response;
            selectCity();
        }
    }

    request.open("GET", "selectDistrictProcess.php?id=" + province_id, true);
    request.send();
}

function selectCity() {

    var district_id = document.getElementById("district").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("city").innerHTML = response;
        }
    }

    request.open("GET", "selectCityProcess.php?id=" + district_id, true);
    request.send();
}

function changeProfileImg() {

    var img = document.getElementById("profileImage");

    img.onchange = function () {
        var file = this.files[0];
        var url = window.URL.createObjectURL(file);

        document.getElementById("img").src = url;

    }
}

function updateProfile() {

    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var city = document.getElementById("city");
    var pcode = document.getElementById("pcode");
    var image = document.getElementById("profileImage");

    var form = new FormData();

    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("m", mobile.value);
    form.append("li1", line1.value);
    form.append("li2", line2.value);
    form.append("c", city.value);
    form.append("p", pcode.value);
    form.append("i", image.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "Updated" || response == "Saved") {
                window.location.reload();
            } else if (response == "You have not selected any Profile Image") {
                alert("You have not selected any Profile Image");
                window.location.reload();
            } else {
                alert(response);
            }
        }
    }

    request.open("POST", "updateProfileProcess.php", true);
    request.send(form);

}

function addColor() {

    var clr = document.getElementById("new_clr");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                Swal.fire({
                    title: "Success!",
                    text: "Color has registered successfully.",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response,
                    icon: "error"
                });
            }
        }
    }

    request.open("GET", "saveColorProcess.php?clr=" + clr.value, true);
    request.send();


}



function changeProductImage() {
    var image = document.getElementById("imageUploader");

    image.onchange = function () {

        var file_count = image.files.length;

        if (file_count <= 3) {
            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("i" + x).src = url;
            }
        } else {
            alert(file_count + " files selected. You can upload only 3 or less than 3 files.");
        }
    }

}

function addProduct() {
    var category = document.getElementById("category");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");
    var condition = 0;
    if (document.getElementById("b").checked) {
        condition = 1;
    } else if (document.getElementById("u").checked) {
        condition = 2;
    }
    var clr = document.getElementById("clr");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("cost");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var desc = document.getElementById("desc");
    var imageUploader = document.getElementById("imageUploader");

    var form = new FormData();
    form.append("ca", category.value);
    form.append("b", brand.value);
    form.append("m", model.value);
    form.append("t", title.value);
    form.append("co", condition);
    form.append("clr", clr.value);
    form.append("qty", qty.value);
    form.append("cost", cost.value);
    form.append("dwc", dwc.value);
    form.append("doc", doc.value);
    form.append("d", desc.value);


    var file_count = imageUploader.files.length;

    for (var x = 0; x < file_count; x++) {
        form.append("image" + x, imageUploader.files[x]);
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                alert("Product saved successfully!")
                window.location.reload();
            } else {
                alert(response);
            }
        }
    }
    request.open("POST", "addProductProcess.php", true);
    request.send(form);
}

function changeStatus(id) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "Deactivated" || response == "Activated") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    }
    request.open("GET", "changeStatusProcess.php?id=" + id, true);
    request.send();
}

function sort1(x) {

    var search = document.getElementById("s");
    var time = "0";

    if (document.getElementById("n").checked) {
        time = "1";
    } else if (document.getElementById("o").checked) {
        time = "2";
    }

    var qty = "0";

    if (document.getElementById("h".checked)) {
        qty = "1";
    } else if (document.getElementById("l")) {
        qty = "2";
    }

    var condition = "0";

    if (document.getElementById("b").checked) {
        condition = "1";
    } else if (document.getElementById("u").checked) {
        condition = "2";
    }

    var form = new FormData();
    form.append("s", search.value);
    form.append("t", time);
    form.append("q", qty);
    form.append("c", condition);
    form.append("page", x);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("sort").innerHTML = response;
        }
    }
    request.open("POST", "sortProcess.php", true);
    request.send(form);
}

function clearSort() {
    window.location.reload();
}

function updateProduct() {

    var title = document.getElementById("t");
    var qty = document.getElementById("q");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var desc = document.getElementById("d");
    var images = document.getElementById("imageUploader");

    var form = new FormData();
    form.append("t", title.value);
    form.append("q", qty.value);
    form.append("dwc", dwc.value);
    form.append("doc", doc.value);
    form.append("d", desc.value);
    form.append("pid", id);

    var count = images.files.length;

    for (var x = 0; x < count; x++) {
        form.append("i" + x, images.files[x]);
    }

    var request = new XMLHttpRequest();

    form.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "Product has been Updated.") {
                window.location = "myProducts.php";
            } else {
                alert(response);
            }
        }
    }

    request.open("POST", "updateProductProcess.php", true);
    request.send(form);

}

function basicSearch(x) {

    var txt = document.getElementById("basic_search_txt");
    var select = document.getElementById("basic_search_select");

    var form = new FormData();
    form.append("t", txt.value);
    form.append("s", select.value);
    form.append("page", x);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("basicSearchResult").innerHTML = response;
        }
    }
    request.open("POST", "basicSearchProcess.php", true);
    request.send(form);


}

function advancedSearch(x) {

    var txt = document.getElementById("t");
    var category = document.getElementById("c1");
    var brand = document.getElementById("b1");
    var model = document.getElementById("m");
    var condition = document.getElementById("c2");
    var color = document.getElementById("c3");
    var from = document.getElementById("pf");
    var to = document.getElementById("pt");
    var sort = document.getElementById("s");

    var form = new FormData();
    form.append("t", txt.value);
    form.append("cat", category.value);
    form.append("b", brand.value);
    form.append("m", model.value);
    form.append("con", condition.value);
    form.append("col", color.value);
    form.append("pf", from.value);
    form.append("pt", to.value);
    form.append("s", sort.value);
    form.append("page", x);


    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("view_area").innerHTML = response;
        }
    }

    request.open("POST", "advancedSearchProcess.php", true);
    request.send(form);
}

function loadMainImg(x) {
    var sample_img = document.getElementById("productImg" + x).src;
    var mainImg = document.getElementById("mainImg");

    mainImg.style.backgroundImage = "url(" + sample_img + ")";
}

function checkQty(qty) {
    var input = document.getElementById("qty_input");

    if (input.value <= 0) {
        alert("Quantity must be 1 or more.");
        input.value = 1;
    } else if (input.value > qty) {
        alert("Insufficient Quantity");
        input.value = qty;
    }
}

function qty_inc(qty) {
    var input = document.getElementById("qty_input");

    if (input.value < qty) {
        var new_val = parseInt(input.value) + 1;
        input.value = new_val;
    } else {
        alert("Maximum Quantity Reached");
        input.value = qty;
    }
}

function qty_dec() {
    var input = document.getElementById("qty_input");

    if (input.value > 1) {
        var new_val = parseInt(input.value) - 1;
        input.value = new_val;
    } else {
        alert("Minimum Quantity Reached");
        input.value = 1;
    }
}

function addToWatchlist(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "Removed" || response == "Added") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    }

    request.open("GET", "addToWatchlistProcess.php?id=" + id, true);
    request.send();
}

function removeFromWatchlist(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "Deleted") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    }

    request.open("GET", "removeWatchlistProcess.php?id=" + id, true);
    request.send();
}

function selectBrand() {

    var categoryId = document.getElementById("category").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("brand").innerHTML = response;
            selectModel();
        }
    }

    request.open("GET", "selectBrandProcess.php?id=" + categoryId, true);
    request.send();
}

function selectModel() {

    var brandId = document.getElementById("brand").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("model").innerHTML = response;

        }
    }

    request.open("GET", "selectModelProcess.php?id=" + brandId, true);
    request.send();
}

function addToCart(id, qty) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            alert(response);
        }
    }
    request.open("GET", "addToCartProcess.php?id=" + id + "&qty=" + qty, true);
    request.send();

}

function deleteFromCart(id) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "removed") {
                alert("Product removed from the cart");
                window.location.reload();

            } else {
                alert(response);
            }
        }
    }
    request.open("GET", "deleteFromCartProcess.php?id=" + id, true);
    request.send();
}

function payNow(id) {

    var qty = document.getElementById("qty_input").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            var obj = JSON.parse(response);

            var mail = obj["umail"];
            var amount = obj["amount"];

            if (response == 1) {
                alert("Please Login to your account.");
                window.location = "index.php";
            } else if (response == 2) {
                alert("Please update your Address.");
                window.location = "userProfile.php";
            } else {

                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);
                    // Note: validate the payment and show success or failure page to the customer

                    alert("Payment completed. OrderID:" + orderId);
                    saveInvoice(orderId, id, mail, amount, qty);

                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": obj["mid"],    // Replace your Merchant ID
                    "return_url": "http://localhost/eshop/singleProductView.php?id=" + id,     // Important
                    "cancel_url": "http://localhost/eshop/singleProductView.php?id=" + id,     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": obj["item"],
                    "amount": obj["amount"] + ".00",
                    "currency": obj["currency"],
                    "hash": obj["hash"], // *Replace with generated hash retrieved from backend
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": obj["umail"],
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": "Kalutara",
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                //document.getElementById('payhere-payment').onclick = function (e) {
                payhere.startPayment(payment);
                // };

            }
        }
    }

    request.open("GET", "buyNowProcess.php?id=" + id + "&qty=" + qty, true);
    request.send();

}

function saveInvoice(orderId, id, mail, amount, qty) {

    var form = new FormData();
    form.append("o", orderId);
    form.append("i", id);
    form.append("m", mail);
    form.append("a", amount);
    form.append("q", qty);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                window.location = "invoice.php?id=" + orderId;
            } else {
                alert(response);
            }
        }
    }

    request.open("POST", "saveInvoiceProcess.php", true);
    request.send(form);

}

function printInvoice() {

    var restorePage = document.body.innerHTML;
    var page = document.getElementById("page").innerHTML;

    document.body.innerHTML = page;

    window.print();

    document.body.innerHTML = restorePage;


}

var m;
function addFeedback(id) {

    var feedbackModal = document.getElementById("feedbackModal" + id);
    m = new bootstrap.Modal(feedbackModal);
    m.show();
}

function saveFeedback(id) {

    var type;

    if (document.getElementById("type1").checked) {
        type = 1;
    } else if (document.getElementById("type2").checked) {
        type = 2;
    } else if (document.getElementById("type3").checked) {
        type = 3;
    }

    var feedback = document.getElementById("feed");
    var product_id = id;

    var form = new FormData();

    form.append("t", type);
    form.append("f", feedback.value);
    form.append("p", product_id);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                alert("ThankYou for your Feedback!");
                m.hide();
            } else {
                alert(response);
            }
        }

    }
    request.open("POST", "saveFeedbackProcess.php", true);
    request.send(form);
}

var c;

function openChat(id) {

    var chatModal = document.getElementById("chatModal" + id);
    c = new bootstrap.Modal(chatModal);
    c.show();
}

function sendMsg() {

    var to = document.getElementById("r");
    var msg = document.getElementById("m");

    var form = new FormData();
    form.append("to", to.value);
    form.append("msg", msg.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {

        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                alert("Message Sent!");
                window.location.reload();
            } else {
                alert(response);
            }
        }
    }
    request.open("POST", "sendMessageProcess.php", true);
    request.send(form);

}

function viewMsg(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("chat_box").innerHTML = response;
        }
    }

    request.open("GET", "viewMsgProcess.php?e=" + email, true);
    request.send();

}

var avm;

function adminVerification() {

    var email = document.getElementById("e");

    var form = new FormData();
    form.append("e", email.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "Success") {
                alert("Please take a look at your email to find the VERIFICATION CODE.");
                var adminVerificationModal = document.getElementById("adminVerificationModal");
                avm = new bootstrap.Modal(adminVerificationModal);
                avm.show();

            } else {
                alert(response);
            }
        }
    }
    request.open("POST", "adminVerificationProcess.php", true);
    request.send(form);

}

function verify() {

    var code = document.getElementById("vcode");

    var form = new FormData();
    form.append("vc", code.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
            if (response == "success") {
                avm.hide();
                window.location = "adminPanel.php";
            } else {
                alert(response);
            }
        }
    }

    request.open("POST", "verificationProcess.php", true);
    request.send(form);

}

function productBlock(id){
    
    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            var response = request.responseText;
            alert (response);
            window.location.reload();
        }
    }

    request.open("GET","productBlockProcess.php?id="+id,true);
    request.send();

}

var vpm;

function viewProductModal(id){
    var pm = document.getElementById("productModal"+id);
    vpm = new bootstrap.Modal(pm);
    vpm.show();
}

var cm;

function categoryModal(){
    var modal = document.getElementById("addCategoryModal");
    cm = new bootstrap.Modal(modal);
    cm.show();
}

function saveCategory(){
    
    var name = document.getElementById("n");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            var response = request.responseText;
            if(response == "success"){
                alert ("New category added!");
                cm.hide();
                window.location.reload();
            }else{
                alert (response);
            }
        }
    }
    request.open("GET","saveCategoryProcess.php?n="+name.value,true);
    request.send();

}

function blockUser(email){

    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            
            var response = request.responseText;
            alert (response);
            window.location.reload();

        }
    }

    request.open("GET","blockUserProcess.php?email="+email,true);
    request.send();

}

var mm;

function viewMsgModal(email){
    
    var msgModal = document.getElementById("msgModal"+email);
    mm = new bootstrap.Modal(msgModal);
    mm.show();

}

function searchinvoice(){

    var id = document.getElementById("searchtxt");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            var response = request.responseText;
            if(response == "Invalid invoice ID." || response == "Please add an invoice number first"){
                alert (response);
                window.location.reload();
            }else{
                document.getElementById("view_area").innerHTML = response;
            }
        }
    }

    request.open("GET","searchInvoiceProcess.php?id="+id.value,true);
    request.send();

}

function findSellings(){
    var from = document.getElementById("from");
    var to = document.getElementById("to");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            var response = request.responseText;
            document.getElementById("view_area").innerHTML = response; 
        }
    }
    request.open("GET","findSellingProcess.php?f="+from.value+"&t="+to.value,true);
    request.send();
}

var cad;

function contactAdmin(){
    var msgModal = document.getElementById("contactAdmin");
    cad = new bootstrap.Modal(msgModal);
    cad.show();
}

function adminChat(){
    
    var msg = document.getElementById("msgtxt");
    var form = new FormData();
    form.append("m",msg.value);
    form.append("e",email);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            
            var response = request.responseText;
            alert (response);
        }
    }
    

    request.open("POST","adminChatProcess.php",true);
    request.send(form);
}

function adminChat(email){
    

    var msg = document.getElementById("msgtxt");
    var email = email;

    var form = new FormData();
    form.append("m",msg.value);
    form.append("e",email);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            
            var response = request.responseText;
            alert (response);
        }
    }
    

    request.open("POST","adminChatProcess.php",true);
    request.send(form);
}