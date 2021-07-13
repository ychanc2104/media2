
<style>



.sidebar_base{
    background: linear-gradient(#144262, #5c7c86);
    width: 12vw;
    height: 120vh;
    /* max-width: 40rem; */
    /* min-height: 100vh; */
    float: left;


}


.sidebar_base_upper{
    height: 15vh;
}


.profile{
    float: right;
    width: 15vw;
}


.profile_logo{
    width: 10vw;
    height: 10vh

}

.account{
    position: relative;
    border: 1px solid #2e7fab;
    border-radius: 8px;
    line-height: 5vh;
    font-weight: 600;
    color: #2e7fab;
    text-align: center;
    font-size: 18px;
    /* display: inline-block; */



    
    /* right: 10vw; */
}


#profileButton{
    background-color:transparent;
    border-color: transparent;
    position: absolute;
    width: 85px;
    height: 70px;
    top: -0px;
}

.language{
    position: relative;
    /* left: 95vw; */
    /* margin-top: 4vh; */
    line-height: 4vh;

}



/* sidebar manu */
.dropdown-manu{
    background-color:transparent;
    color: white;
    font-weight: 700;
    font-size: 20px;
    margin-left: 1vw;
    margin-bottom: 2vh;
    border-color: transparent;
}

/* sidebar item */
.dropdown-item-text{
    text-decoration:none;
    background-color:transparent;
    color: white;
    font-weight: 600;
    font-size: 16px;
    margin-left: 1vw;
    margin-bottom: 2vh;
    border-color: transparent;

}
/* set color for item hover */
.dropdown-item-text:hover{
    color: #1E90FF;
}



/* logo in up-left corner */
#hodo_logo{
    position: absolute;
    width: 8rem;
    height: 8rem;
    left: -2rem;
    top: -2rem; 
}


/* main div for content(right hand side) */
.content{
    background-color: gainsboro;
    width: 83vw;
    height: 100vh;
    float: right;
    margin: 20px 20px 20px 0vw;

}

/* 數據總覽 */
.overview{
    /* width: 100px; */
    /* height: 80px; */
    /* line-height: 80px; */
    font-weight: bold;
    font-size: 20px;
    text-align: left;
    padding: 0px 0px 0px 10px;
    color: #2e7fab;
}

/* Likr推播 （title） */
.tab_title{
    background-color:white;
    width: 250px;
    height: 80px;
    line-height: 80px;
    font-weight: bold;
    font-size: 20px;
    text-align: center;
    border-radius: 10px 30px 10px 0;
    box-shadow: 10px 5px 5px grey;
    margin: 10px 0px 10px 10px;
}




#tab_total_attr{
    width: 18rem;
    max-width: calc(100% - 20px);
    border-width: 5px 0px 0px 0px;
    color: black;
}

/* position of google charts */
#tab_total_profit, #tab_total_impression, #tab_total_click, #tab_total_click_rate{
    margin-left: 0px;

}


#drop_item{
    cursor: pointer;
}



.add_pointer{
    cursor: pointer;
}


</style>