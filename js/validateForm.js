$('.addTask, .updateTask').submit(function (event) {
    event.preventDefault();
    let valid = true;

    let title = $(this).children('input[name="title"]');
    let description =$(this).children( 'textarea[name="description"]');
    let subordinateID = $(this).find('input[name="subordinateID"]');
    let priorityID = $(this).find('input[name="priorityID"]');
    let finished_at = $(this).children('input[name="finished_at"]');


    title.prev().children('span').text("");
    description.prev().children('span').text("");
    subordinateID.parent().prev().children('span').text("");
    priorityID.parent().prev().children('span').text("");
    finished_at.prev().children('span').text("");
    if (title.val() == '') {
        title.prev().children('span').text("Обязательное поле");
        valid = false;
    }
    if (description.val() == '') {
        description.prev().children('span').text("Обязательное поле");
        valid = false;
    }
    if (subordinateID.length > 0) {
        if (subordinateID.val() == '') {
            subordinateID.parent().prev().children('span').text("Обязательное поле");
            valid = false;
        }
    } else {
        subordinateID.parent().prev().children('span').text("Обязательное поле");
        valid = false;
    }

    if (priorityID.length > 0) {
        if (priorityID.val() == '') {
            priorityID.parent().prev().children('span').text("Обязательное поле");
            valid = false;
        }
    } else {
        priorityID.parent().prev().children('span').text("Обязательное поле");
        valid = false;
    }
    if (finished_at.val() == '') {
        finished_at.prev().children('span').text("Обязательное поле");
        valid = false;
    }
    if (valid) {
        $(this).unbind('submit').submit();
    }

});