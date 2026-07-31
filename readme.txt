TITOLO DEL PROGETTO:
Sito web dinamico di un’agenzia di viaggi – Homework 3

AUTORI:
Danila Gatto
Repository GitHub:
https://github.com/danilagatto/HOMEWORK3-LWEB

Luca Lauretti
Repository GitHub:
https://github.com/lucalau00/HOMEWORK-3-LWEB


DESCRIZIONE DEL PROGETTO:

Questo progetto rappresenta l'evoluzione del sito realizzato nei precedenti homework. 
Dopo aver sviluppato una prima versione completamente statica e una seconda versione dinamica con PHP e MySQL, in questo terzo homework abbiamo ampliato ulteriormente il sito introducendo XML e XSD. 
L'obiettivo era quello di realizzare un'applicazione web più completa e organizzata, in cui i dati fossero separati dalla presentazione e validati tramite uno schema dedicato.
Il sito simula il funzionamento di un’agenzia di viaggi online.
Gli utenti possono consultare le destinazioni e gli itinerari,registrarsi, effettuare il login, aggiungere viaggi alle proprie prenotazioni, rimuovere una prenotazione, simulare un pagamento, consultare lo storico dei pagamenti effettuati e il proprio carrello.
Per la creazione di questo terzo homework abbiamo utilizzato varie tecnologie. Le pagine pubbliche sono state realizzate in HTML5 e XHTML, mentre la parte grafica è stata curata attraverso fogli di stile CSS. 
La logica dell'applicazione è stata sviluppata in PHP, che ci ha permesso di gestire autenticazione, prenotazioni, pagamenti e interazione con il database MySQL. Abbiamo inoltre introdotto XML per organizzare alcune informazioni in documenti strutturati e XSD per verificarne automaticamente la correttezza.

NUOVE FUNZIONALITA':
Nell'homework precedente, tutti i dati utilizzati dal sito provenivano principalmente dal database MySQL oppure erano inseriti direttamente nelle pagine. Con XML abbiamo iniziato a rappresentare alcune informazioni attraverso documenti strutturati, indipendenti dal codice delle pagine. 
Questo significa che i dati possono essere modificati senza dover intervenire sulla logica del sito, rendendo il progetto più ordinato e semplice da mantenere.
Le pagine del sito si occupano di mostrare le informazioni all'utente, mentre i file XML hanno il solo compito di conservarle in modo organizzato. Questa suddivisione rende il progetto più modulare e facilita eventuali modifiche future.
Abbiamo utilizzato anche gli schemi XSD. Lo schema definisce infatti come deve essere costruito un documento XML: quali elementi devono essere presenti, in quale ordine, quali tipi di dati sono ammessi e quali informazioni sono obbligatorie.
In questo modo, prima ancora che il sito utilizzi un documento XML, è possibile verificarne automaticamente la correttezza. Se un elemento è scritto in modo errato, manca un dato obbligatorio oppure un valore non rispetta il formato previsto, il documento non supera la validazione. 
Questo permette di individuare gli errori in anticipo e rende il progetto molto più affidabile.

AREA AMMINISTRATORE:
Oltre all'area riservata agli utenti registrati, il sito dispone anche di una sezione dedicata all'amministratore, utilizzato per raccogliere tutte le funzionalità relative ai documenti XML e ai relativi schemi XSD.
Per accedere a questa sezione è sufficiente utilizzare la normale pagina di login, inserendo le credenziali dell'amministratore:
Email: admin@gmail.com
Password: admin
Se le credenziali inserite corrispondono a quelle dell'amministratore, il sistema non reindirizza all'area personale dell'utente, ma apre direttamente una sezione dedicata all'amministrazione dei documenti XML.
All'interno di questa area sono presenti delle tabelle organizzate, pensate per facilitare la consultazione dei file utilizzati nel progetto.
Questa sezione è accessibile esclusivamente all'amministratore e non può essere visualizzata dagli utenti registrati. 
In questo modo è stata mantenuta una chiara separazione tra le funzionalità destinate ai clienti del sito e gli strumenti dedicati alla gestione e al controllo dei documenti XML e XSD.

FUNZIONALITÀ PRINCIPALI

- Visualizzazione delle destinazioni e degli itinerari
- Registrazione di un nuovo utente
- Autenticazione tramite email e password
- Gestione delle sessioni utente
- Accesso a un’area personale
- Visualizzazione dinamica delle offerte di viaggio
- Inserimento di uno o più viaggi nelle prenotazioni
- Controllo delle prenotazioni duplicate
- Rimozione di una singola prenotazione
- Calcolo automatico del costo totale
- Simulazione del pagamento
- Registrazione dei pagamenti nel database
- Visualizzazione dello storico dei pagamenti
- Visualizzazione del carrello


TECNICHE PRINCIPALI UTILIZZATE

- Inclusione di file tramite require_once
- Separazione dei dati generali di configurazione
- Connessione al database tramite MySQLi
- Query SQL SELECT, INSERT e DELETE
- Prepared statement
- Utilizzo di bind_param()
- Gestione dei form tramite metodo POST
- Utilizzo delle variabili di sessione
- Utilizzo dei campi hidden
- Cifratura delle password tramite password_hash()
- Verifica delle password tramite password_verify()
- Stampa sicura dei dati tramite htmlspecialchars()
- Reindirizzamento tramite header()
- Installazione automatica del database tramite install.php
- Validazione delle pagine e dei fogli di stile tramite W3C


STRUTTURA DEL DATABASE

Il database viene creato e popolato automaticamente tramite il file: install.php.
Il nome del database e i dati necessari alla connessione sono definite nel file: dati_generali.php
Per questa copia del progetto il nome del database è:
luca.lauretti.XML_DOM

Le principali tabelle del database sono:

- cliente
- viaggio
- prenotazione
- pagamento
- bali
- kyoto
- reykjavik
- losangeles

Il file install.php crea il database, costruisce le tabelle e inserisce i dati iniziali relativi alle destinazioni e alle offerte disponibili.
Non è necessario importare manualmente un file SQL tramite phpMyAdmin.


CONFIGURAZIONE
Le impostazioni generali del database sono contenute esclusivamente nel file: dati_generali.php

All’interno di questo file possono essere modificati:

- host del server MySQL
- nome utente MySQL
- password MySQL
- nome del database
- nomi delle tabelle

I file connection.php e install.php includono dati_generali.php.

In questo modo, per installare il progetto su un server diverso, è sufficiente modificare un solo file, evitando di ripetere gli stessi
dati in più punti dell’applicazione.


INSTALLAZIONE

1. Copiare la cartella del progetto nella directory del server web.

   Con XAMPP, per esempio:

   C:\xampp\htdocs\luca.lauretti.XML_DOM

2. Aprire il file dati_generali.php.

3. Controllare che il nome del database sia impostato in questo modo:

   $nome_database = "luca.lauretti.XML_DOM";

4. Controllare ed eventualmente modificare:

   - host MySQL
   - nome utente MySQL
   - password MySQL

5. Avviare Apache e MySQL tramite XAMPP.

6. Aprire dal browser il file install.php:

   http://localhost/luca.lauretti.XML_DOM/install.php

7. Attendere la conferma del completamento dell’installazione.

8. Aprire la pagina iniziale del sito:

   http://localhost/luca.lauretti.XML_DOM/Home.xhtml

CREDENZIALI DI ACCESSO
Il database creato da install.php non contiene utenti predefiniti.
Per utilizzare le funzionalità riservate del sito è necessario creare
un nuovo account tramite la pagina:
account.php
Dopo la registrazione è possibile effettuare l’accesso tramite:
login.php
L’utente deve quindi scegliere autonomamente la propria email e la propria password durante la registrazione.

PAGINE PRINCIPALI

- Home.xhtml
  Pagina iniziale pubblica del sito

- home2.php
  Home dell’area personale dell’utente autenticato

- login.php
  Pagina per l’accesso degli utenti

- account.php
  Pagina per la registrazione di un nuovo utente

- destinazioni.xhtml
  Destinazioni presenti nella parte pubblica

- destinazioni2.php
  Destinazioni disponibili nell’area personale

- bali.php
  Visualizzazione e prenotazione delle offerte per Bali

- kyoto.php
  Visualizzazione e prenotazione delle offerte per Kyoto

- reykjavik.php
  Visualizzazione e prenotazione delle offerte per Reykjavik

- losangeles.php
  Visualizzazione e prenotazione delle offerte per Los Angeles

- prenotazione.php
  Visualizzazione e gestione delle destinazioni scelte dall’utente

- pagaora.php
  Simulazione e registrazione del pagamento

- storicoviaggi.php
  Visualizzazione dello storico dei pagamenti dell’utente

- connection.php
  Gestione della connessione al database

- dati_generali.php
  Definizione delle impostazioni generali del database

- install.php
  Creazione e popolamento automatico del database


PAGINE STATICHE

Il progetto contiene anche alcune pagine statiche derivate
dall’Homework 1:

- Home.xhtml
- Chi_siamo.xhtml
- destinazioni.xhtml
- Itinerario.xhtml
- Last_minut.xhtml
- meteestive.xhtml
- meteinvernali.xhtml

Le pagine:

- chi_siamo2.xhtml
- Itinerario2.xhtml
- last_minute2.xhtml

sono versioni utilizzate nell’area personale e contengono collegamenti
adatti alla navigazione dell’utente autenticato.

FILE XML:
I file con estensione .xml contengono i dati utilizzati dal sito in un formato strutturato e leggibile, questi documenti hanno principalmente lo scopo di rappresentare i dati in formato XML e di mostrarne l'organizzazione.
Nel progetto sono presenti i seguenti documenti:

- bali.xml: Contiene le informazioni relative alle offerte e agli itinerari della destinazione Bali.

- kyoto.xml: Raccoglie tutti i dati relativi alle offerte disponibili per la destinazione Kyoto.

- losangeles.xml: Contiene le informazioni riguardanti i viaggi e gli itinerari di Los Angeles.

- reykjavik.xml: Descrive le offerte dedicate alla destinazione Reykjavik.

- viaggi.xml: È il documento XML principale dedicato ai viaggi. Riunisce le informazioni generali sulle destinazioni disponibili e rappresenta una visione complessiva delle offerte presenti nel sito.

- cliente.xml: Contiene i dati relativi agli utenti registrati. Viene utilizzato per rappresentare le informazioni dei clienti in formato XML.

- prenotazione.xml: Memorizza le informazioni riguardanti le prenotazioni effettuate dagli utenti, come i viaggi scelti e i relativi dettagli.

- pagamento.xml: Contiene lo storico dei pagamenti registrati dal sistema, rappresentando in formato XML le operazioni effettuate dagli utenti.

FILE XSD:
Lo scopo di questi file è definire le regole che i documenti XML devono rispettare.

Ogni schema specifica:
quali elementi devono essere presenti;
quali attributi sono consentiti;
il tipo di dato di ogni elemento (stringa, numero, data, ecc.);
l'ordine corretto degli elementi;
quali campi sono obbligatori e quali facoltativi.

Nel progetto troviamo quindi:

- bali.xsd: Definisce la struttura che deve rispettare il documento bali.xml.

- kyoto.xsd: Valida il contenuto di kyoto.xml.

- losangeles.xsd: Controlla che losangeles.xml sia conforme alla struttura prevista.

- reykjavik.xsd: Valida il documento reykjavik.xml.

- viaggi.xsd: Definisce la struttura generale del documento viaggi.xml.

- cliente.xsd: Specifica come devono essere organizzati i dati dei clienti all'interno di cliente.xml.

- prenotazione.xsd: Verifica la correttezza delle informazioni contenute in prenotazione.xml.

- pagamento.xsd: Controlla la struttura del documento pagamento.xml.

FILE PHP PRESENTI NELLA CARTELLA XML:
Oltre ai documenti XML e XSD sono presenti alcuni file PHP dedicati alla loro gestione.

- export_cliente_document.php: Si occupa di esportare i dati dei clienti dal database in un documento XML. In questo modo le informazioni memorizzate in MySQL vengono trasformate in un file XML consultabile e validabile.

- mostra_cliente_document.php: Legge il documento XML dei clienti e ne visualizza il contenuto in una pagina web, rendendo i dati facilmente consultabili dall'amministratore.

- validate_cliente_document.php: Ha il compito di verificare che il documento cliente.xml rispetti tutte le regole definite nel file cliente.xsd. Se il documento è corretto viene mostrato un messaggio di conferma; in caso contrario vengono segnalati gli eventuali errori di validazione.

FUNZIONAMENTO DEL SITO

Quando l'utente apre il sito viene visualizzata la home page, dalla quale può consultare le principali sezioni dell'agenzia di viaggi. 
Se desidera prenotare un viaggio deve prima creare un account ed effettuare il login. Una volta autenticato accede all'area riservata, dove può esplorare le destinazioni disponibili, aggiungere le offerte alle proprie prenotazioni e visualizzare il costo totale. 
Dopo aver simulato il pagamento, il sistema registra l'operazione nel database e rende disponibile lo storico degli acquisti effettuati.
Il pagamento viene simulato nella pagina pagaora.php e registrato nella tabella pagamento.
Dopo il pagamento, le prenotazioni presenti nel carrello vengono rimosse.
Lo storico dei pagamenti effettuati può essere visualizzato tramite la pagina storicoviaggi.php.


PROBLEMI AFFRONTATI E SOLUZIONI

Un primo problema riguardava la coerenza tra i documenti XML e i relativi schemi XSD. In alcuni casi gli XML contenevano elementi non previsti nello schema, oppure gli identificativi erano rappresentati come elementi nell’XML e come attributi nell’XSD. Sono stati quindi uniformati i nomi degli elementi, l’ordine dei dati, gli attributi obbligatori e i tipi, utilizzando ad esempio xs:date per le date e xs:decimal per gli importi.

È stato inoltre necessario gestire correttamente i file XML vuoti, come nel caso di un documento senza prenotazioni o pagamenti. Negli schemi XSD è stato aggiunto minOccurs="0", permettendo così la validazione anche quando non sono ancora presenti record.

Un altro problema riguardava la generazione del file cliente.xml. La prima versione del codice PHP produceva una struttura diversa da quella richiesta da cliente.xsd. Il problema è stato risolto tramite DOM, rappresentando id_cliente come attributo, utilizzando nomi coerenti per gli elementi e creando i nodi testuali con createTextNode().

Durante la gestione delle prenotazioni è emerso che, dopo il pagamento, le righe venivano eliminate dalla tabella prenotazione. Di conseguenza, l’amministratore non riusciva più a visualizzare le prenotazioni già pagate. È stata quindi aggiunta la colonna stato, che distingue le prenotazioni nel_carrello da quelle pagata. Dopo il pagamento, le prenotazioni non vengono più cancellate, ma aggiornate, permettendo all’utente di avere un carrello vuoto e all’amministratore di conservare lo storico delle prenotazioni.

Un altro problema riguardava l’area amministratore, che utilizzava ancora il vecchio database e connessioni scritte direttamente nelle pagine. Tutti i file dell’area admin sono stati modificati per utilizzare connection.php e i nomi delle tabelle definiti in dati_generali.php. In questo modo l’amministratore può visualizzare correttamente clienti, prenotazioni, stato delle prenotazioni e pagamenti.



VALIDAZIONE

Tutte le pagine sono state controllate tramite il validatore HTML W3C. Gli errori individuati durante la validazione sono stati corretti.

NOTE

- Per il corretto funzionamento devono essere attivi Apache e MySQL.
- Il database non deve essere importato manualmente.
- install.php può essere eseguito più volte senza eliminare gli utenti,
  le prenotazioni e i pagamenti già presenti.
- Per eseguire un’installazione completamente pulita è necessario
  eliminare preventivamente il database esistente.
- Dopo l’installazione è necessario registrare un nuovo account tramite
  account.php.