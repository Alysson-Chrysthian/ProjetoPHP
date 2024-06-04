function ShowPopUp(popUpId) 
{
    let PopUp = document.getElementById(popUpId);
    PopUp.style.display = 'block';
}

function ClosePopUp(popUpId)
{
    let PopUp = document.getElementById(popUpId);
    PopUp.style.display = 'none';
}