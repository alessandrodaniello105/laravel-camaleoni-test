<script type="text/javascript">
    // BOTTONI DESELEZIONE
    const deselectButtons    = document.querySelectorAll('.deselect-btn');

    // BOTTONI AGGIUNGI
    const addButtons         = document.querySelectorAll('.add-btn');

    // LISTE MUSICISTI PER STRUMENTO
    const instrumentsSelects = document.querySelectorAll('.form-select');
    console.log(deselectButtons);

    [...deselectButtons].forEach((button,indexBtn) => {
        button.addEventListener('click', function() {

            [...instrumentsSelects].forEach((select,indexSelect) => {

                if (indexBtn === indexSelect) {
                    select.selectedIndex = -1;
                }
            })

        })
    })

    let manualBandForm = document.getElementById('test-form');

    function send() {

        for(element of manualBandForm){
            // console.log(element)
            if (element.classList == "form-select") {
                for(listItem of element) {
                    console.log(listItem.value);
                }
            }
        }

        // console.log(manualBandForm)
    }


    // let manualBandList             = document.getElementById('manual-band-select');

    // function send() {
    //     // let manualBandListOptions = manualBandList.options;
    //     // manualBandForm.submit(manualBandListOptions);
    //     console.log(document.getElementById('test-form'))
    // }
    // let musiciansLists = document.getElementsByClassName('form-select');


    // console.log(musiciansLists);



</script>
