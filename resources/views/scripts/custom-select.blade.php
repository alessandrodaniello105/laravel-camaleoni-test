<script type="text/javascript">
    // BOTTONI DESELEZIONE
    const deselectButtons    = document.querySelectorAll('.deselect-btn');

    // BOTTONI AGGIUNGI
    const addButtons         = document.querySelectorAll('.add-btn');

    // LISTE MUSICISTI PER STRUMENTO
    const instrumentsSelects = document.querySelectorAll('.form-select');
    console.log(deselectButtons);

    let manualBandForm = document.getElementById('test-form');

    let manualBandSelect = document.getElementById('manual-band-select');

    let classList = addButtons[0].classList;

    const isMultipleRandomCheckbox = document.getElementById('isMultipleRandom');

    const howManyMusicians = document.getElementById('how-many-musicians');

    const howManyRandomBandsInput = document.getElementById('how-many-random-bands');

    [...deselectButtons].forEach((button,indexBtn) => {
        button.addEventListener('click', function() {

            [...instrumentsSelects].forEach((select,indexSelect) => {

                if (indexBtn === indexSelect) {
                    select.selectedIndex = -1;
                }
            })

        })
    })

    let isDefault = true;

    isMultipleRandomCheckbox.addEventListener('click', function() {
        if (isDefault) {
            howManyRandomBandsInput.disabled = false;
            howManyMusicians.disabled = true;
            isDefault = false;
        } else {
            howManyRandomBandsInput.disabled = true;
            howManyMusicians.disabled = false;
            isDefault = true;
        }

    })


    for (className of classList) {
        if (className === 'disabled') {
            console.log('instrument picked')
        } else {
            console.log('instrument not picked')
        }
    };

    let testJson;

    if ( {{ count($pickedInstruments) }} > 1 ) {
        console.log('maggiore di 1')
        // testJson = {{in_array('Drums',$pickedInstruments)}};
    }

    // for (element of ) {
    //     console.log(element)
    // }

    // let howManyMusiciansAreInThere = cache.keys().then((keys) => {
    //                                     keys.forEach((request, index, array) => {
    //                                     console.log(request);
    //                                     });
    //                                 });

    // let manualBandList             = document.getElementById('manual-band-select');

    // function send() {
    //     // let manualBandListOptions = manualBandList.options;
    //     // manualBandForm.submit(manualBandListOptions);
    //     console.log(document.getElementById('test-form'))
    // }
    // let musiciansLists = document.getElementsByClassName('form-select');


    // console.log(musiciansLists);



</script>
