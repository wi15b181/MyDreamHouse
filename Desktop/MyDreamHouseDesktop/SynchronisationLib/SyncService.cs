using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SharedLibrary;
using SharedLibrary.Entities;

namespace SynchronisationLib
{
    public class SyncService
    {
        WebServiceConnector wsc;
        DAOConnector daoc;
        public SyncService()
        {
            wsc = new WebServiceConnector();
            daoc = new DAOConnector();
        }

        public int Ping()
        {
            return wsc.Ping();
        }

        public void FullSync()
        {
            //Zuerst lokale Ädnerungen an WS schicken.
            //Hauspaket  Attachement   AttrZuord

            List<SyncJnEntity> pendingSyncs = daoc.GetPendingSyncs();
            foreach (var sync in pendingSyncs)
            {
                if (sync.JnTable.ToUpper() == "HAUSPAKET")
                {
                    HauspaketEntity hausPaket = daoc.GetHauspaket(sync.JnPk);
                    List<AttachmentsEntity> attach = daoc.GetAttachments(sync.JnPk);
                    List<HauspaketAttributZuordEntity> zuords = daoc.GetHauspaketAttributZuordnungen(sync.JnPk);
                    wsc.SendChanges(hausPaket, attach, zuords, sync.JnOperation);
                    sync.Synced = true;
                    daoc.UpdateSyncJournal(sync);
                }
            }

            //Alle Daten vom WebService abfragen.
            var data = wsc.FullSync();
            // Wenn erfolgreich, dann Alle Tabellen Leeren
            /* INSERT ORDER ei Delete umgekehrt!!!
             * 1    hauspaket_attribut              D
             * 2    hauspaket_attribut_wert         D
             * 3    hauspaket_attribut_regel        D
             * 4    hersteller                      D
             * 5    berater                         D
             * 6    hauspaket                       D
             * 7    attachements                    D
             * 8    hauspaket_attrib_zuord          D
             */
            if (data != null)
            {
                daoc.ClearHauspaketAttributZuord();
                daoc.ClearAttachements();
                daoc.ClearHauspaket();
                daoc.ClearBerater();
                daoc.ClearHersteller();
                daoc.ClearHauspaketAttributRegel();
                daoc.ClearHauspaketAttributWert();
                daoc.ClearHauspaketAttribut();
            }

            foreach (var item in data.HauspaketAttributTable)
            {
                daoc.SyncHauspaketAttribut(item);
            }

            foreach (var item in data.HauspaketAttributWertTable)
            {
                daoc.SyncHauspaketAttributWert(item);
            }

            foreach (var item in data.HauspaketAttributRegelTable)
            {
                daoc.SyncHauspaketAttributRegel(item);
            }

            foreach (var item in data.HerstellerTable)
            {
                daoc.SyncHersteller(item);
            }

            foreach (var item in data.BeraterTable)
            {
                daoc.SyncBerater(item);
            }

            foreach (var item in data.HauspaketTable)
            {
                daoc.SyncHauspaket(item);
            }

            foreach (var item in data.AttachementsTable)
            {
                daoc.SyncAttachments(item);
            }

            foreach (var item in data.HauspaketAttributZuordTable)
            {
                daoc.SyncHauspaketAttributZuord(item);
            }


        }

        /* TODO: 
             * Durchführen der INSERTS UPDATES DELETES in localDB
             * Auslesen des Sync Journals
             * Senden der Änderungen über WebService
             */

        /* INSERT ORDER
         * 1    hauspaket_attribut
         * 2    hauspaket_attribut_wert
         * 3    hauspaket_attribut_regel
         * 4    hersteller
         * 5    berater
         * 6    hauspaket
         * 7    attachements
         * 8    hauspaket_attrib_zuord
         */
    }
}
