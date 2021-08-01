function fun(event) {
    //alert($(this).find(':selected').data("nid"));

    event.preventDefault();
    //var nid = $('#delBtn').data("nid");
    var recordId = event.currentTarget.dataset.nid;
    //alert(nid);
    if (
        confirm(
            "This action will delete this record. Are you sure? \n ID-" + recordId
        )
    ) {
        document.getElementById('message').innerHTML = "deleting";

        const url = 'http://fridayapp.cu.ma/lawncare/node/' + recordId;

        const other_params = {
            headers: {
                "Authorization": "Basic YWRtaW46ZHJ1cGFsQCMwMDc=",
                "X-CSRF-Token": "2Hfop35H4HAL9fUSNNc6JiKa0YjG4Mp_TSf2w6KEZIc",
                "Content-Type": "application/hal+json",
            },
            method: "DELETE",
            // data : {nid :nid }
        };

        fetch(url, other_params)
            .then(function (response) {
                if (response.ok) {
                    //document.getElementById("msg1").classList.add("visible");
                    //document.getElementById("msg1").classList.remove("invisible");
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 800);
                } else {
                    throw new Error("Could not reach the API: " + response.statusText);
                }
            }).then(function (data) {
                //document.getElementById("msg1").classList.add("visible");
                // document.getElementById("msg1").classList.remove("invisible");
                document.getElementById("message").innerHTML = data.encoded;
            }).catch(function (error) {
                document.getElementById("message").innerHTML = error.message;
            });
        return true;
        //validation code to see State field is mandatory.
    }
}