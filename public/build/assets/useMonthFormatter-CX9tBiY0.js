function n(e,{capitalize:r=!1}={}){const t=new Intl.DateTimeFormat("pl-PL",{month:"long",year:"numeric"}).format(new Date(e));return r?t.charAt(0).toUpperCase()+t.slice(1):t}export{n as f};
