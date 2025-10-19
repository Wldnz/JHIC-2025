
const main_portfolio = document.querySelector('.main-portfolio');
const other_portfolio = document.querySelector('.other-portfolio');

let curentPortfolio = [];

function getPortfolios(){
    try{
        return portfolios;
    }catch(error){
        return [];
    }
}

function setActionPorfolio(){
    document.querySelectorAll('.portfolios').forEach(element => {
        element.addEventListener('click', () => changeMainPorfolioHandler(element))
    });
}

function changeMainPorfolioHandler(e){
    const title = e.children[1].textContent;
    const portfolio = getPortfolios().find(p => p.title == title);
    if(!portfolio) return;
    
    curentPortfolio = portfolio;
    changeMainPortfolio(portfolio);
    setOtherPortfolio();
    setActionPorfolio();
}

function changeMainPortfolio(portfolio){
    const img = main_portfolio.children[0];
    const title = main_portfolio.children[1];
    const description = main_portfolio.children[2];
    const student_name = main_portfolio.children[3];

    img.src = portfolio.portfolio_images[0].url;
    img.alt = portfolio.title;

    title.textContent = portfolio.title;
    description.textContent = portfolio.description;
    student_name.textContent = portfolio.student_name;
}

function setOtherPortfolio(){
    let stringHtml = '';
    getPortfolios().forEach((portfolio, index) => {
        if(portfolio.id === curentPortfolio.title) return;
        stringHtml += `<div class="portfolios ${index == 0? 'selected' : ''}">
              <img src="${portfolio.portfolio_images[0].url}" alt="${portfolio.title}">
              <h5>${portfolio.title }</h5>
            </div>`;
    });
    other_portfolio.innerHTML = stringHtml;
}

setActionPorfolio();