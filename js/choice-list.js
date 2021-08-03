$('.select').each(function () {
    const _this = $(this),
        selectOption = _this.find('option'),
        selectOptionLength = selectOption.length,
        selectedOption = selectOption.filter(':selected'),
        duration = 450; // длительность анимации
    let nameInputForPost = _this.attr('class').split(' ')[1];
    let inputSubmit = false;
    if (nameInputForPost === 'subordinateID' || nameInputForPost === 'priorityID') {
        inputSubmit = false;
    } else if (nameInputForPost === 'dateGroup' || nameInputForPost === 'subIDGroup') {
        inputSubmit = true;
    }
    _this.hide();
    //создание формы
    _this.wrap('<div class="select"></div>');
    $('<div>', {
        class: 'new-select',
        text: _this.children('option:disabled').text()
    }).insertAfter(_this);

    const selectHead = _this.next('.new-select');
    $('<div>', {
        class: 'new-select__list'
    }).insertAfter(selectHead);


    const selectList = selectHead.next('.new-select__list');
    for (let i = 1; i < selectOptionLength; i++) {
        $('<div>', {
            class: 'new-select__item',
            value: selectOption.eq(i).attr('value'),
            html: $('<span>', {
                text: selectOption.eq(i).text(),
            })

        })
            .appendTo(selectList);
    }

    //Работа с инпутом
    let input;
    if (inputSubmit) {
        input = $('<input>', {
            type: 'submit',
            name:nameInputForPost
        }).insertAfter(selectHead);
        input.css('display', 'none')
    }
    else {
        input = $('<input>', {
            type: 'hidden',
            name:nameInputForPost
        }).insertAfter(selectHead);
    }


    const selectItem = selectList.find('.new-select__item');
    selectList.slideUp(0);
    selectHead.on('click', function () {
        if (!$(this).hasClass('on')) {
            $(this).addClass('on');
            selectList.slideDown(duration);

            selectItem.on('click', function () {
                let chooseItem = $(this).data('value');

                $('select').val(chooseItem).attr('selected', 'selected');
                selectHead.text($(this).find('span').text());
                input.val($(this).attr('value'));

                selectList.slideUp(duration);
                selectHead.removeClass('on');

                //запись в input нашего value
                if(inputSubmit) {
                    input.click();
                }
            });
        } else {
            $(this).removeClass('on');
            selectList.slideUp(duration);

        }
    });
});

$('.status').click(function (e) {
    event.stopPropagation();
    let oldChoose = $(this).parent().find('.choose-status');
    oldChoose.removeClass('choose-status');
    oldChoose.removeClass('sub-choose-status');
    oldChoose.removeAttr('name');
    $(this).attr('name', 'statusID');
    $(this).addClass('choose-status');
    $(this).addClass('sub-choose-status');
});