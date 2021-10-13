function proccessPayment(token)
{
    let data = {
        card_token: token,
        hash: PagSeguroDirectPayment.getSenderHash(),
        installment: document.querySelector('select.select_installments').value,
        card_name: document.querySelector('input.card_name').value,
        _token: csrf
    }

    $.ajax({
        type: 'POST',
        url : urlProccess,
        data: data,
        dataType: 'json',
        success: function(res) {
            toastr.success(res.data.message, 'Sucesso')
            window.location.href = `${urlThanks}?order=${res.data.order}`
        }
    })
}

function getInstallments(amount, brand) {
    PagSeguroDirectPayment.getInstallments({
        amount : amount,
        brand  : brand,
        maxInstallmenstNoInterest: 0,
        success : function(res) {
            let selectInstallments = drawSelectInstallments(res.installments[brand])
            document.querySelector('div.installments').innerHTML = selectInstallments
        }
    })
}

function drawSelectInstallments(installments) {
    let select = '<label>Opções de parcelamento'

    select+= '<select class="form-control select_installments">'

    for(let i of installments) {
        select += `<option value="${i.quantity}|${i.installmentAmount}">${i.quantity}x de ${i.installmentAmount} - Total fica ${i.totalAmount}</option>`
    }

    select+= '</select>'

    return select
}