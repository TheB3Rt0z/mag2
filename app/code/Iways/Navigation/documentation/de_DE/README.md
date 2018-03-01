## i-ways Magento 2 Navigation Module

### Grundlegendes

- Durch klicken auf den "Parent erstellen" Knopf wird ein Level-0 Node erstellt.
    - Wenn der Node mit einem link assoziiert werden soll, können Sie: 
        - Den Link in das "Link" Eingabefeld eingeben und dann auf den "Parent erstellen" Knopf drücken
        - Den Link im Nachhinein ändern, indem Sie den Node auswählen, dessen Link Sie ändern wollen.
          Der Link, mit dem der Node assoziiert ist erscheint in dem Link-input. Dort können Sie nun einen
          neuen eingeben und durch einen Klick auf den "Aktualisieren" Knopf speichern.
        - Geben Sie nicht die komplette URL ein, es reicht der Pfad
    - Links können einfach Wörter sein, die auf Unterseiten Ihrer Webseite zeigen. Ein Beispiel wäre "bücher"; 
      der resultierende Link wäre "http://www.ihre-website.de/bücher.html"
    - Link können auch auf externe Seiten zeigen. Dafür muss die komplette URL eingegeben werden, also z.B.
      "http://www.externe-webseite.de/". 
    - Sie können einen Link jederzeit überprüfen und ändern, indem Sie den zugehörigen Node auswählen.
- Wenn Sie einen Parent-Node ausgewählt haben ändert sich der "Parent erstellen" Knopf automatisch in den
  "Child erstellen" Knopf. Mit diesem Knopf können Sie so viele Child-Nodes zu dem ausgewählten Node hinzufügen
  wie Sie wollen. Child-Node Links funktionieren genauso wie bei den Parent-Nodes.
- Jeder Child-Node kann wiederum Child-Nodes besitzen.
- Mit dem "Kategorien einfügen" Knopf fügen Sie alle Kategorien Ihres Magento Stores, die das "Include in Menu" Attribut
  gesetzt haben, dem Baum hinzu.
- Kategorie Nodes können nicht umbenannt, verschoben oder einzeln gelöscht werden, allerdings können Sie eigene Nodes 
  zwischen den obersten Kategorie Nodes erstellen.
- Wenn Sie die Kategorien eingefügt haben, werden Sie feststellen, dass sich der "Kategorien einfügen" Knopf in den
  "Kategorien entfernen" Knopf geändert hat. Dieser entfernt (wie der Name vermuten lässt) wieder alle Kategorien aus
  Ihrem Baum.
- Die Parent-Nodes werden als Menüpunkte in der Navigationsleiste Ihres Stores zu sehen sein. Die jeweiligen Child-Nodes 
  erscheinen, wenn Sie mit der Maus über die Hauptpunkte der Navigationsleiste fahren
- !Wichtig: der Baum wird erst endgültig gespeichert, wenn Sie auf den "Save Config" Knopf drücken.
- 
      
### Controlls

- Das Drücken des "Parent erstellen" oder "Child erstellen" Knopfes oder der Taste "n" auf der Tastatur fügt einen Node
  zum Baum hinzu. 
- Durch Doppelklicken auf einen Node oder Drücken von "f2" können Sie den ausgewählten Node umbenennen. Node-Namen 
  können bis zu 30 Zeichen lang sein.
- Nodes können gelöscht werden, indem Sie sie auswählen und den "Entfernen" Knopf bzw. die "Entf" Taste auf der Tastatur
  drücken.
- Sie können im Baum auch mit den Pfeiltasten navigieren.
- Einen Node können Sie mit der Maus oder auch mit der Leertaste auswählen.
- Nodes können durch einen Mausklick irgendwo auf die Seite oder durch drücken der "Esc" Taste auf der Tastatur
  abgewählt werden.
- Nodes können durch gedrückthalten der linken Maustaste im Baum verschoben werden.
- Durch das Drücken der "Strg" Taste auf der Tastatur können mehrere Nodes gleichzeitig ausgewählt, veschoben oder
  gelöscht werden.
- Kategorien können mit der "c" Taste eingefügt oder entfernt werden.
- Durch die "l" Taste können Sie zur Link-eingabe springen.
- Eingegebene Links können mit der "enter" Taste gespeichert werden.
- Ja/Nein fragen können mit "enter" (ja) und "esc" (nein) beantwortet werden.