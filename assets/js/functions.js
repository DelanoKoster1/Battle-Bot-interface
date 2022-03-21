function getDomainName(){
    return window.location.href.replace('http://','').replace('https://','').split(/[/?#]/)[0];
}