Redovisning
====================================


###Kmom01: PHP-baserade och MVC-inspirerade ramverk

Jag tycker detta kursmoment gick ganska smärtfritt frammåt, mycket att läsa men jag tror samtidigt att det kommer vara väldigt nyttigt att läsa mycket om just MVC ramverk då det känns som ett mycket effektivt sätt att utveckla hemsidor på, förutsatt att man kodar korrekt och effektiv kod. Började läsa lite i phalcons dokumentation och än så länge så får man en hyfsad förståelse om varför man ska använda sig av MVC-ramverk gentemot något annat. Jag tror att just denna dokumentation kommer vara något jag kommer att försöka läsa parallellt med kursen.


####Vilken utvecklingsmiljö använder du?
Min utvecklingsmiljö är just nu en windows 8.1 maskin, kör Xampp-server och har testat på att använda mig utav sublime text. Använde mig av notepad++ tidigare och ville helt enkelt testa på något nytt. För att föra över filer till studentservern så använder jag mig av FileZilla, men detta kan kommas att ändras då jag hade tänkt testa sublimes sftp plugin där man kan ladda upp filer "direkt" ifrån texteditorn.


####Är du bekant med ramverk sedan tidigare?
Det enda med ramverk som jag är bekant med sedan tidigare är vad vi gjorde i förra php-kursen. Men jag har inte använt mig av MVC-ramverk innan. Så det har varit mycket att ta in när man nu blev presenterad till just MVC-ramverk. Jag tycker att guiden om Me-sidan med ANAX-MVC var bra men jag kände att jag snabbt blev rätt så förvirrad när det kommer till mappstrukturen i ramverket. Det är väl mest för att man inte är van vid en sådan komplicerad struktur, jag tror att man vänjer sig efter ett tag. Det kommer nog ta ett kursmoment eller två till innan jag riktigt har kommit in i tänkandet vad gäller MVC-ramverk.


####Är du sedan tidigare bekant med de lite mer avancerade begrepp som introduceras?
Det mesta var nytt, förkortningar som SOLID, DRY, KISS fick vi ju höra lite om i förra kursen så dem sitter kvar sen dess. Jag har inte hört talas om just termen Dependency Injection innan, men efter att man läst nu så förstod man ju att vi redan i förra kursen delvis implementerade just Dependency Injection för att försöka dela upp koden och göra den mer återanvändbar.


####Din uppfattning om Anax, och speciellt Anax-MVC?
När jag började och skulle pussla ihop me-sidan så upplevde jag Anax-MVC lite komplicerat och jag förstod inte uplägget av de olika delarna. Men efter att ha jobbat klart med me-sidan känner jag att jag fått en bättre förståelse över hur det mesta hänger samman. Jag har inte riktigt koll på hur allt fungerar ännu men det hoppas jag att jag kan läsa på lite tills nästa kursmoment.


###Kmom02: PHP-baserade och MVC-inspirerade ramverk

Det var mycket att läsa till detta kursmoment och jag har inte riktigt läst allt det som rekommenderades i phalcon och Yiis dokumentation, men det är något som jag har tänkt att göra då jag ska försöka att göra en hemsida med hjälp av phalcon på en raspberry pi, mest för att få en bättre koll på hur dessa ramverk verkligen fungerar.


####Hur känns det att jobba med Composer?
Composer verkar vara ett väldigt bra verktyg ifall man snabbt vill implementera en ny modul i sitt ramverk, jag hade inga större problem med att få det till att fungera, så de första stegen i detta kursmoment gick snabbt att göra. Det enda lilla problemet var att jag råkat installera composer på fel ställe första gången jag installerade det, men en ominstallation senare löste sig allt.


####Vad tror du om de paket som finns i Packagist, är det något du kan tänka dig att använda och hittade du något spännande att inkludera i ditt ramverk?
Jag gillade verkligen Packagist, det är verkligen något jag kommer att använda i framtiden när jag utökar mitt ramverk. Eftersom det finns så mycket olika sorters färdiga paket som kan användas till så mycket olika saker så känns Packagist som ett väldigt bra verktyg att ha med sig. Jag kollade runt lite snabbt i Packagist och hittade några olika paket som jag i framtiden kan tänka mig använda. Ett av dessa packet var symfony/translation, som gör exakt det den heter.


####Hur var begreppen att förstå med klasser som kontroller som tjänster som dispatchas, fick du ihop allt?
Jag känner att jag har någorlunda koll på hur det fungerar med dispatchern, men som sagt så ska jag läsa mer för att få en bättre förståelse. Men det var smidigt att använda sig av de tjänster som var dispatchade, jag hittade flera i ramverket som jag använde mig av.


####Hittade du svagheter i koden som följde med phpmvc/comment? Kunde du förbättra något?
Den enda svagheten i phpmvc/comment som jag kunde hitta var att datan som skickades in i formuläret inte validerades någonstans. Men jag antar att det är en implementation som jag kan göra i samband med att man kan logga in och att man kan jobba mot en databas. Det känns inte som att säkerhet är prio ett för detta kursmomentet. Utöver det så tycker jag att den koden man fick var en bra grund att stå på. Det hjälpte mig att förstå hur jag skulle göra för att implementera tabort och redigerings tilläggen. Jag har även lagt till ett par bilder som ser ut ungefär som Disqus upvote och downvote pilar. Dessa är inte implementerade men det är något jag hade tänkt att göra om inte nu under kursmomentens gång så under projektet.


####Extra

Jag har lagt till så bilder av användarna laddas in med hjälp av gravatar. Samt att formuläret inte är synligt förrän man har tryckt på textarean, jag gjorde det med JQuery. Jag har inte använt mig av JQuery mycket innan så det var kul att leka lite med det. Utöver detta så bytte jag min texteditor till Atom för att kunna testa att implementera ett par linters. Så nu har jag validering av php, phpmd, phpcs. Det tog ett tag att få det att fungera men när det väl fungerade så är det en stor hjälp.


###Kmom03: Bygg ett eget tema

####Vad tycker du om CSS-ramverk i allmänhet och vilka tidigare erfarenheter har du av dem?
Jag tycker att css-ramverk är ett väldigt bra verktyg att kunna om man snabbt vill göra något som är snyggt, responsivt och enkelt att underhålla. Jag har själv använt mig av twitters bootstrap i oophp kursen och jag tyckte det var ett väldigt roligt sätt att styla en hemsida på när man väl kommit in i hur det fungerar. Jag vet inte om bootstrap använder sig av LESS eller SASS, men jag har inte använt mig av dem tidigare.

####Vad tycker du om LESS, lessphp och Semantic.gs?
De är alla bra verktyg att ha med sig i framtiden och jag tror att jag inte kommer att använda mig av vanlig css längre utan försöka att byta till att använda mig av LESS istället. Less var enkelt att använda, mycket mer flexibel än vanlig css och mycket lättare att strukturera med variabler och funktioner. Semantic är nog det som mest liknar det jag använt tidigare i bootstrap med kolumner. Jag tycker det är ett effektivt sätt att göra en hemsida som skalar bra på dator, platta och mobil. Sen att man får ett enkelt sätt att göra hemsidan "perfekt". Med perfekt menar jag att all padding, margin och bredd blir samma för alla kolumner på en rad och på så sätt ser hemsidan bättre strukturerad ut.

####Vad tycker du om gridbaserad layout, vertikalt och horisontellt?
Vertikal layout har jag använt mig av tidigare men horisontellt gridlayout är något jag inte ägnat en tanke åt innan. Men jag kan verkligen se mig själv bygga hemsidor i framtiden med det i verktygslådan. Att ha ett horisontellt gridlayout gör att sidan ser mer professionellt gjord.

####Har du några kommentarer om Font Awesome, Bootstrap, Normalize?
Även här så har jag aldrig ägnat en tanke åt att man faktiskt kunde reseta alla värden på nästan alla html-elementen och på så sätt på en universell look på dem. Det är ju perfekt att ha med sig när man programmerar framtida hemsidor. Jag gillar verkligen Font Awesome, har använt mig av bootstraps glyphicons när jag programmerade hemsidor i förra kursen. Och så länge man inte  överanvänder dem så kan dem tillföra mycket till en hemsida.

####Beskriv ditt tema, hur tänkte du när du gjorde det, gjorde du några utsvävningar?
Mitt tema är väl inget speciellt, har utgått ifrån mos grund. Jag har inte ändrat speciellt mycket därifrån. Har mitt grid med ett antal olika fält. Det jag ändrat mest är väl hur footern ser ut och var kommentarerna placeras. Hade väldiga problem med att placera ut kommentarssektionen, vad jag än gjorde så ville den inte flytta på sig, frågade i forumet och på 10 minuter hade jag svaret. Det vara bara att lägga till en parameter i slutet av där man addade viewn.

####Antog du utmaningen som extra uppgift?
Nope, tidsbrist hände.


###Kmom04: Databasdrivna modeller

####Vad tycker du om formulärshantering som visas i kursmomentet?
Jag gillar det verkligen, som det är nu har jag valt att lägga varje formulär i sin egen klass och den klassen har i sin tur en egen kontroller. Två av dessa som jag gjort i detta kursmoment är CFormComment och CFormUser som gör det som dem heter. Jag gillar strukturen, fast jag måste erkänna att det tog ett tag att få ihop allting så det funkade. Hade mina hinder på vägen, där ett av dem var att jag inte visste hur jag skulle få ut informationen ifrån CFormComment och -user metod callbacksubmit. Jag vet inte säkert ifall min lösning är speciellt bra då det är något jag använder bara av den enkla anledningen att den fungerar. Skulle gärna vilja ha lite mer feedback på hur jag skulle kunna skriva denna funktion bättre, eller helt enkelt hantera alltihop på ett bättre sätt. Fick inte updateAction till att bli som jag ville utan gjorde ett nytt formulär istället för att använda det som redan fanns. Även här skulle jag uppskatta en del feedback på bättre lösningar.

Jag tycker att även om det blir svårare kod att skriva, så verkar det vara ett effektivt sätt att göra det på.

####Vad tycker du om databashanteringen som visas, föredrar du kanske traditionell SQL?
Samma som ovanstående, jag gillar det verkligen, just detta kändes som ett naturligt sätt att hantera SQL anrop. Kanske för att jag inte är speciellt SQL "insatt" och undviker det nästan så ofta jag kan när jag programmerar. Men på detta sättet så känns det enkelt att använda och väldigt återanvändbart. Detta slår att skriva vanliga SQL anrop varje gång. Visst finns det kanske några fördelar med att kunna skriva "ren" SQL kod i vissa sammanhang, men när man enbart ska implementera CRUD så känns det som denna databashantering är en perfekt matchning.

####Gjorde du några vägval, eller extra saker, när du utvecklade basklassen för modeller?
Valde att lägga all kod i basklassen CDatabaseModel då jag lyckades göra så att alla funktioner i den fungerar för alla klasser, $this->getSource har varit till en stor hjälp. Jag valde att implementera stöd för alla extra databas relaterade metoder som finns i TSQLQueryBuilerBasic-klassen såsom, join, right-join, left-join, orderBy, groupBy, limit och offset. Jag kommer nog aldrig att använda dem alla i kursen men jag tänkte att det var något som var bra att ha med sig om man nu vill göra mer komplicerade SQL anrop i framtiden.

####Beskriv vilka vägval du gjorde och hur du valde att implementera kommentarer i databasen.
Kommentarerna är istort sätt en kopia av hur användarna fungerar. Jag utgick efter vad jag redan hade gjort i user klasserna och kopierade dem rakt av. Det enda jag egentligen gjorde annorlunda var att jag implementerade möjligheten att kunna skriva kommentarer på olika sidor. Databasen skiljer dem åt med ett attribut som heter $pageId och som är hela urlen till i mitt fall, antingen webroot eller webroot/redovisning. Fast inte bara den delen utan hela urlen. Jag tyckte det var ett enkelt sätt att skilja dem åt.


####Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.
Nej jag gjorde inte extrauppgiften. Detta kursmoment var svårt att få ihop och det tog mycket längre tid än vad jag trodde att det skulle ta. Slösade rätt mycket tid på att leta buggar, en bugg som tog 3timmar att hitta var att jag när jag skulle $di->set en kontroller så råkade jag länka till fel mapp. Vilket gjorde att det såg rätt ut men inte alls fungerade.


###Kmom05: Bygg ut ramverket

####Var hittade du inspiration till ditt val av modul och var hittade du kodbasen som du använde.
Inför den här uppgiften så läste jag igenom alla exempel som beskrevs i "Bygg ut ditt Anax MVC med en egen modul och publicera via Packagist". Jag kände väl att alla förslag på moduler hade sina fördelar och de kan nog alla vara viktiga att ha tillgång till i sitt ramverk. Men eftersom jag har begränsad tid till att göra uppgifter just nu så var jag tvungen att begränsa mig rätt kraftigt. Så jag gjorde två av dem som jag kom fram till var viktigast, CLog och CCache. Jag vet inte riktigt om dessa kursmoment någonsin kommer att ha så pass mycket information så dem behöver cachas, eller att man behöver kolla efter bottlenecks i funktioner. Men då man i framtiden kan stöta på sådana problem kände jag att det vore ett bra verktyg att ha med sig så man kan lösa sådana uppgifter då. Jag utgick efter mos gamla ramverk Lydia och kodbasen som gavs för just CLog och CCache. Ändrade lite i CLog då några av positionerna i $this->timestamp aldrig initierades. Men lite felsökning och flyttandes på kod så löste sig det problemet. Har även uppdaterat syntaxen för funktionerna till PSR-4 standard med camelCase. Bytte även ut alla array() syntaxer mot den mycket mer behagligare [] syntaxen. Mycket mer än så blev det inte i CLog. I CCache blev det lite mer att ändra då CCache från Lydia har en massa andra metoder inkluderade ifrån andra klasser i Lydia vilket gjorde att jag först inte ville göra CCache, men efter att ha kollat igenom de relaterade filerna så såg jag att jag kunde ta bort några delar av CCache och på så sätt göra den mer självständig. Det är mest i konstruktorn som det blev mest ändrat. Fixade även här till syntaxen på alla ställen som i CLog. Hade jag haft mer tid att spendera på detta kursmoment så hade jag nog försökt på mig en mer User relaterad modul, som både hanterar inloggning och administration, men det får bli till projektet istället.

####Hur gick det att utveckla modulen och integrera i ditt ramverk?
Efter förra kursmomentet så kändes detta som ett hyfsat lätt kursmoment och under utvecklingen av modulen så hade jag knappt inga problem och det flöt på väldigt bra under hela detta kursmoment. Jag hade inga som helst problem med att integrera dem i mitt ramverk. Satte båda som en shared service i frontkontrollern index.php och när jag hade modulerna som egna klasser i anax src katalog så fungerade det felfritt, stötte däremot på ett par små hinder när jag gjorde om dem till egna fristående moduler då jag hade missat att ändra namespace i båda filerna. Det tog en stund innan jag insåg vad som inte stod rätt till, men det var den största motgången i detta kursmoment så jag klagar inte.

####Hur gick det att publicera paketet på Packagist?
Även här så gick saker och ting felfritt, jag publicerade två paket jejd14/CLog och jejd14/CCache och förutom en liten miss från min sida i en av .json filerna så var det väldigt enkelt att hämta informationen ifrån github och vips så hade jag två paket på packagist! Hade dock lite små problem med git och github men det är nog pga att jag fortfarande är lite av en nybörjare. Jag har väl inte spenderat mer tid än jag behövt tidigare på github, men det beteendet får man försöka ändra på.

####Hur gick det att skriva dokumentationen och testa att modulen fungerade tillsammans med Anax MVC?
Här var det något jag först inte alls såg fram emot, att skriva dokumentation på github. Detta var något jag sköt på in i det sista, men när jag väl kom igång med att skriva lite markdown så fick jag ändå ihop två ganska snygga och väl informerande README filer. Och när jag gjort så båda filerna var required i min main composer.json fil så fungerade dem felrfritt, ändrade lite kod i frontkontrollern så den skulle hitta dem igen men utöver det så var det inga större problem.

####Gjorde du extrauppgiften?
Nope.
