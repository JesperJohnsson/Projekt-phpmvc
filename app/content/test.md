###Kmom06: Verktyg och CI

Detta kursmoment gick ganska smärtfritt igenom hela processen, stötte på några problem med github, ungefär som i förra kursmomentet, där jag råkade lägga till en fil/katalog och inte visste hur jag skulle ändra/ta bort den. Men efter om och möda och lite genomgång av github igen så kom jag in i hur github fungerar igen. Efter det så gick allt enbart framåt och väldigt bra. Efter både kursmoment 4 och 5 så var detta kursmoment inte alls svårt att genomföra.

####Var du bekant med några av dessa tekniker innan du började med kursmomentet?
PHPUnit testing, code coverage, continuous integration, automated tests och code quality, är några helt nya begrepp för mig och inget jag arbetat med förut.
Jag hade ingen aning om att det fanns hemsidor som scrutinizer och travis så det var intressant att få testa dem och se hur dem fungerar och hur man går tillväga för att använda dem.

####Hur gick det att göra testfall med PHPUnit?
Jag tycker inte det var några större problem med att göra testfallen. Försökte göra så alla funktioner i varje klass åtminstonde testades en gång, detta ledde till att jag gjorde en test funktion för varje riktig funktion i mina två klasser. Jag följde ju så som man skulle göra i förra kursmomentet vilket gjorde att det var väldigt enkelt att skapa en test klass som fungerade felfritt då mina två klasser är fristående moduler.

####Hur gick det att integrera med Travis?
Samma som ovan, hade inga egentliga problem här heller. Jag tycker att Travis var väldigt smidig att använda då man kunde logga in med sitt GitHub konto vilket underlättade då man direkt fick se sina repos i en lista. Hade ett litet problem med min .travis fil då jag råkat lägga den i fel mapp utan att jag själv insåg att men efter lite extra läsning insåg jag vad som var fel.

####Hur gick det att integrera med Scrutinizer?
När man väl hade fått igång Travis var det ju hur enkelt som helst att sätta upp en config fil och allt fungerade första gången jag testade. Så här har jag ingenting att klaga på!

####Hur känns det att jobba med dessa verktyg, krångligt, bekvämt, tryggt? Kan du tänka dig att fortsätta använda dem?
Till en början så kändes det rätt så omständigt, jag såg inte riktigt anledningen till varför man skulle behöva göra så många olika tester fram och tillbaka. Det känns som att den här första tröskeln man måste komma över när man sätter upp ett större projekt kan vara lite omständig men när man väl fått ihop allt och det fungerar som det ska då är det ju väldigt bra verktyg att ha med sig i framtiden. Jag tror att om man bara arbetar in en regelbunden användning av verktygen så man vänjer sig vid den här första tröskeln då är den direkta feedbacken på koden man skriver perfekt.
