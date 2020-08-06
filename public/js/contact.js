$( document ).ready(function()  {
$("#btnSubmit").on("click",function(e){
    console.log("cliqué");
    e.preventDefault();
    var lname = $("#lname").val();
    var fname = $("#fname").val();
    var email = $("#email").val();
    
    var choiceArr = [];
    $(".checkbox").each(function(){
        var bool = $( this )[0].checked;
        if(bool===true){
           choiceArr.push({id:$( this ).attr("data-id"), name:$( this ).attr("data-name")})
        }
    })

    $.ajax({
        url:'/contact/sendmail',
        type: "POST",
        dataType: "json",
        data: {
            'name' : `${fname} ${lname}`,
            'email': email,
            "choix":choiceArr

        },
        async: true,
        success: function(data) {
            console.log(data)

            $("#modal").removeClass("hidden");

           
        


        }
    });
    console.log(choiceArr)
})

$("#modalBouton").on("click", function(){
    $("#modal").addClass("hidden")
})
})  