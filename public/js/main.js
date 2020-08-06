// N'executer ce code que quand le DOM est complètement chargé
$( document ).ready(function()  {

//Trouve tous les éléments de l'html avec la classe .images et en fait un array
    var images = $(document).find('.images');
    

// Fonction pour positionner les images cachées
    positionInitiale(images)


// Action quand une image est cliquée
    images.on("click", function(e){


// Ne fonctionne que si l'image cliquée n'a pas la classe .image-principale
        if (!$(this).hasClass("image-principale")){


// Déclaration des variables (basées sur des éléments du DOM)
            var principalImage = $(document).find('.image-principale');
            var imageGauche = $(document).find('.image-gauche');
            var imageDroite = $(document).find('.image-droite');
            var currentTarget = $(this).attr("data-target");
            var textZone = $(document).find('.zone-texte');
            $(textZone[currentTarget-1]).css("display", "block");

// Ne fonctionne que si l'image cliquée à la classe .image-gauche
            if ($(this).hasClass("image-gauche")){

// Modifications du DOM avec JQuery
                principalImage.removeClass("image-principale").addClass("image-secondaire image-droite")

//Texte suivant caché
                $(textZone[currentTarget-1]).next().css("display", "none");
                imageDroite.removeClass("image-secondaire image-droite").addClass("image-cachee").css('left', 600)

                $(this).removeClass("image-secondaire image-gauche").addClass("image-principale")

// Check pour voir si il s'agit de la première image ou non, si ce n'est pas le cas, montrer l'image précédente qui était cachée
                if(currentTarget > 1){
                    var PreviousTarget = $(this).prev()
                    PreviousTarget.removeClass("image-cachee").css('left', '').addClass("image-secondaire image-gauche")
                }
            }

// Ne fonctionne que si l'image cliquée est à droite
            else{
               
// Modifications du DOM avec JQuery
                principalImage.removeClass("image-principale").addClass("image-secondaire image-gauche")
                imageGauche.removeClass("image-secondaire image-gauche").addClass("image-cachee").css('left', -600)
                $(this).removeClass("image-secondaire image-droite").addClass("image-principale")

//Texte précédent caché
                $(textZone[currentTarget-1]).prev().css("display", "none");
                $(this).removeClass("image-secondaire image-gauche").addClass("image-principale")
    
// Check pour voir si il s'agit de la dernière image ou non, si ce n'est pas le cas, montrer l'image suivante qui était cachée
                if(currentTarget < images.length){
                    
                    var NextTarget = $(this).next()

                    NextTarget.removeClass("image-cachee").css('left', '').addClass("image-secondaire image-droite")
                } 
            }

        }
    })
  });


//Fonctions

function positionInitiale(arr){
    // Positionne les images cachées à gauche et à droite sans avoir à le faire manuellement 
    var boolSide = false

    var textZone = $(document).find('.zone-texte');

    $.each(arr,function(i,image){
//Cache les textes qui ne sont pas en lien avec l'image principale
        $(textZone[i]).css("display","none")
        if ($(image).hasClass("image-principale")){
            boolSide = true
//Montre le texte qui est en lien avec l'image principale
            $(textZone[i]).css("display","block")
        }
        if ($(image).hasClass("image-cachee") && boolSide === false){
            $(image).css('left', -600)

        }
        else if($(image).hasClass("image-cachee") && boolSide === true){
            $(image).css('left', 600)
        }

    })
}