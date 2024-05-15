{{-- <script src="/resources/js/" />   <!-- it might not work if path isn't clear --> --}}

<script type="text/javascript">
    // Instruments buttons group
    const instrumentsBtns = document.getElementsByName('instrument_id');

    // Form send button
    const formSendBtn     = document.getElementById('btn-form-send');

    const nameInputField  = document.getElementById('name');
    const surnameInputField  = document.getElementById('surname');

    let isInstrumentSelected = false;

    // Client-side Validation - Obligatory Fields
    // let isMinLengthName = false;
    // let isMinLengthSurname = false;
    let isMinChecked = false;

    let isMinLength = {
        nameMin: false,
        surnameMin: false,

    }



    // If instrument is selected, make the flag true
    if (isInstrumentSelected == false) {
        instrumentsBtns.forEach(el => {
            el.addEventListener("click", () => {
                isInstrumentSelected = true;
                enableSendingForm()
            } );
        });
    };

    function enableSendingForm() {
        if (isInstrumentSelected && isMinChecked) {
            formSendBtn.classList.remove('disabled');
        }
    }


    // make a function to check input field length for client's form validation
    function checkInput(field) {
        let inputField = document.getElementById(field);

        if (inputField.value.length >= 3 && field == 'name') isMinLength.nameMin = true;
        else if (inputField.value.length >= 3 && field == 'surname') isMinLength.surnameMin = true;
        // else {
        //     isMinLength.nameMin = false;
        //     isMinLength.surnameMin = false;
        //     formSendBtn.classList.add('disabled')
        // };

        if (isMinLength.nameMin && isMinLength.surnameMin) isMinChecked = true;

        enableSendingForm();
    }


    function editingMode() {
        let nameLength       = nameInputField.value.length;
        let surnameLength    = surnameInputField.value.length;
        let instrumentBadges = [];

        instrumentBadges = [...instrumentsBtns].filter(el => el.checked);

        console.log(nameLength);
        console.log(surnameLength);


        if (nameLength >= 3 && surnameLength >= 3 && instrumentBadges.length > 0) {
            isInstrumentSelected = true;
            isMinChecked = true;
            console.log('ti trovi in una edit')
            enableSendingForm();
        } else {
            isMinLength.nameMin = false;
            isMinLength.surnameMin = false;
            isMinChecked = false;
            formSendBtn.classList.add('disabled')
        }
    }

    editingMode();

</script>

