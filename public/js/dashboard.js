
$( document ).ready(function() {


    $('#liste-prestas').on('click',".bouton-delete", function(e) {
        console.log("test bouton")
        var id = $(this).attr('data-id')
        var parent = $(this).parent()
        console.log(id)
        $.ajax({
            url:'/tableau-de-bord/liste/delete',
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            },
            async: true,
            success: function(data) {
                parent.remove();

            }
        });

    })


    $('.bouton-categorie').on('click', function(e) {
        var id = $(this).attr('data-id')
        $('.bouton-categorie').each(function(){
            $(this).removeClass("active")
        })
        $(this).addClass("active")
        $("#liste-prestas").html("<h3>Chargement en cours...</h3>")
        // console.log(id)
        $.ajax({
            url:'/tableau-de-bord/getprestations',
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            },
            async: true,
            success: function(data) {
                $("#liste-prestas").html("")
                for(i=0; i< data.length; i++){
                    $("#liste-prestas").append(`<li class="prestation-row">${data[i].name} - ${data[i].price}€ <button class="bouton-delete" data-id="${data[i].id}">Supprimer</button></li> <hr>`)
                    console.log(data[i].name);
                }

    
    
            }
        });
        $('#bouton-ajout').attr("data-id", id)

        $('#prestationCategorie').val(id);
    })

    $('#bouton-ajout').on('click', function(e) {
        e.preventDefault();

        
        var id = $(this).attr('data-id')
        var name = $("#prestationName").val();
        var price = $("#prestationPrice").val();
        var categorie = $("#prestationCategorie").val()

        $.ajax({
            url:'/tableau-de-bord/newPrestationApi',
            type: "POST",
            dataType: "json",
            data: {
                'name': name,
                'price': price,
                'categorie': id,

            },
            async: true,
            success: function(data) {
                console.log(data)
                $("#liste-prestas").append(`<li class="prestation-row">${name} - ${price}€ <button class="bouton-delete" data-id="${id}">Supprimer</button></li>`)

    
            }
        });
    
    })


});
