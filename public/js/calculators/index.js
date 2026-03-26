document.addEventListener('DOMContentLoaded', function () {

    const allChoice = document.querySelectorAll('.choiceAllTransfer');
    const pointsAndMoney = document.getElementById('container-pointAndMoney');

    if (allChoice.length > 0) {
        allChoice.forEach(choice => {
            choice.addEventListener('click', function () {
                const allContainers = document.querySelectorAll('.choice-container');
                allContainers.forEach(container => {
                    container.style.display = 'none';
                });
                const container = document.querySelector('#container-' + choice.getAttribute('data-type'));
                container.style.display = 'block';
            });
        });
    }

    function updateResults(container) {
        let factor, bonus, pointsSent, moneyValue, pointsProgramA, factorAToB, myCpm;

        if (document.querySelector('#'+container+' #conversionRate')) {
            factor = parseFloat(document.querySelector('#'+container+' #conversionRate').value) || 0;
        }
        if (document.querySelector('#'+container+' #bonus')) {
            bonus = parseFloat(document.querySelector('#'+container+' #bonus').value) || 0;
        }
        if (document.querySelector('#'+container+' #points')) {
            pointsSent = parseFloat(document.querySelector('#'+container+' #points').value) || 0;
        }
        if (document.querySelector('#'+container+' #moneyValue')) {
            moneyValue = parseFloat(document.querySelector('#'+container+' #moneyValue').value) || 0;
        }

        if (document.querySelector('#'+container+' #pointsProgramA')) {
            pointsProgramA = parseFloat(document.querySelector('#'+container+' #pointsProgramA').value) || 0;
        }

        if (document.querySelector('#'+container+' #conversionRateProgramA') != null) {
            factorAToB = document.querySelector('#'+container+' #conversionRateProgramA').value;
        }
        if (container == 'container-indirectTransferALL' && factorAToB == 0) {
            return;
        } else if (container == 'container-indirectTransferALL' && factorAToB != 0) {
            const pointsAToB = pointsProgramA / factorAToB;
            const bonusAToB = document.querySelector('#'+container+' #bonusProgramA').value;
            document.querySelector('#'+container+' #points').value = pointsAToB + (pointsAToB * bonusAToB / 100);
        }

        if (container == 'container-myProgramsTransferALL') {
            const select = document.querySelector('#' + container + ' #originProgram');
            if (select.value == 0) {
                return;
            }
            myCpm = select.value;
            moneyValue = (pointsSent / 1000) * myCpm;
        }

        if (factor === 0) return;
      
        // Pontos convertidos: pontos enviados / fator * 1000
        let basePoints
        if (container == 'container-myProgramsTransferALL') {
            basePoints = pointsSent > 0 ? (pointsSent / factor) / 1000 : 0;
        } else {
            basePoints = (pointsSent / factor) / 1000;
        };
      
        // Aplicando bônus
        const finalPoints = (basePoints * (1 + bonus / 100)) * 1000;

        // Valor do Euro baseado na regra: 1000 pontos = 20 euros
        const euroValue = finalPoints > 0 ? (moneyValue / ((finalPoints / 1000) * 20)) : 0;
      
        // CPM em R$
        const cpmAll = finalPoints > 0 ? (moneyValue / finalPoints * 1000) : 0;
      
        // CPM em euros
        const cpmAllEuro = euroValue > 0 ? (cpmAll / euroValue) : 0;

        // Atualiza na tela

        document.querySelector('#' + container + ' #realConversion').textContent = (pointsSent / finalPoints).toFixed(2);
        document.querySelector('#'+container+' #euroValue').textContent = 'R$ ' + euroValue.toFixed(2);
        document.querySelector('#'+container+' #cpmAll').textContent = 'R$ ' + cpmAll.toFixed(2);
    }

    function updateResultsPointsAndMoney() {
        const points = pointsAndMoney.querySelector('#points').value;
        const moneyValue = pointsAndMoney.querySelector('#moneyValue').value;
        const conversionRate = pointsAndMoney.querySelector('#conversionRate').value;
        const bonus = pointsAndMoney.querySelector('#bonus').value;
        const totalPointsResult = pointsAndMoney.querySelector('#totalPoints');
        const finalRatioResult = pointsAndMoney.querySelector('#finalRatio');
        const cpmResult = pointsAndMoney.querySelector('#cpm');

        if (conversionRate == 0) return;

        const totalPoints = (points / conversionRate) * (1 + (bonus / 100));

        totalPointsResult.textContent = totalPoints.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' pontos';

        if (moneyValue > 0) {
            cpmResult.textContent = (moneyValue / totalPoints * 1000).toFixed(2);
        }
        
        finalRatioResult.textContent = (totalPoints / points).toFixed(2);
        // = (totalPoints / moneyValue) * 1000;

    }

      // Escuta mudanças nos inputs
    document.querySelectorAll('#container-directTransferALL input').forEach(input => {
        input.addEventListener('input', function() {
            updateResults('container-directTransferALL');
        });
    });

    document.querySelectorAll('#container-indirectTransferALL input').forEach(input => {
        input.addEventListener('input', function() {
            updateResults('container-indirectTransferALL');
        });
    });

    document.querySelectorAll('#container-myProgramsTransferALL input').forEach(input => {
        input.addEventListener('input', function() {
            updateResults('container-myProgramsTransferALL');
        });
    });

    if (pointsAndMoney) {
        pointsAndMoney.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                updateResultsPointsAndMoney('container-pointAndMoney');
            });
        });
    }



});