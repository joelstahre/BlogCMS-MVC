#Test Fall för php projekt

(blog main)
###TestFall Navigera till bloggen
1. Navigera till sidan
2. Se max 3 bloginlägg åt gången.

### TestFall Navigera till sidan, inga postinlägg finns
1. Navigera till sidan
2. bloggen innehåller inga poster
3. Systemet presenterar att det inte finns några tillgänliga poster.

### TestFall Klicka på ett specifikt inägg
1. Klicka på ett specefikt post inlägg
2. det specifika inlägget presenteras i sin helhet med kommentar funktion.

### TestFall Modifiera url (enskillt inlägg)
1. Klicka på ett specefikt post inlägg
2. modifiera url till ett inlägg som ej finns.
3. Systemet presenterar att inlägget inte finns.

### TestFall 5 Kommentera utan någon data
1. Klicka på ett specefikt inlägg
2. Klicka på kommentera
3. Systemet presenterar felmeddelande för de fält som inte är ifyllda.

### TestFall Kommentera med giltig kommentar
1. Klicka på ett specefikt inlägg
2. Fyll i giltiga uppgifter i kommentars fältet
3. Klicka på kommentera
4. Kommentaren sparas och visas.



(admin)
### TestFall Skapa ny post
1. Fyll i title och content
2. klicka på submit
3. Rätt meddelande att posten har sparats visas

### TestFall Skapa ny post med taggar i titel
1. skriv html tag i title
2. fyll i content
3. Systemet presenterar att man har använt ogiltiga tecken.

### TestFall Skapa ny post utan att ange en kategori
1. fyll i giltig titel och content
2. kryssa inte i någon kategori
3. Ny post skapas med default kategorin Uncategorized

### TestFall Ta bort post
1. klicka på remove
2. posten raderas och meddelande visas att det lyckats


### TestFall Ta bort post med modiferad url 
1. Modifiera url till en post som inte finns
2. Systemet presenterar felmeddelande att posten som försökte tas bort inte finns.


### TestFall Ta bort kommentar
1. klicka på remove
2. kommentaren raderas och meddelande visas att det lyckats


### TestFall Ta bort kommentar med modiferad url 
1. Modifiera url till en kommentar som inte finns
2. Systemet presenterar felmeddelande att kommentaren som försökte tas bort inte finns.


### TestFall Ta bort kategori
1. klicka på remove
2. kategori raderas och meddelande visas att det lyckats


### TestFall Ta bort kategori med modiferad url 
1. Modifiera url till en kategori som inte finns
2. Systemet presenterar felmeddelande att kategorin som försökte tas bort inte finns.


### TestFall redigera i settings genom att sudda ut värderna och klicka save
1. sudda ut värderna
2. klicka save
3. Felmeddelande om at fälten inte får vara tomma.
FUNGERAR EJ, EJ HUNNIT!!!


(login)

(install)


