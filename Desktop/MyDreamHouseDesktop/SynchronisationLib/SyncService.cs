using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

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

        public void FullSync()
        {
            var data = wsc.FullSync();

            /* TODO: 
             * Durchführen der INSERTS UPDATES DELETES in localDB
             * Auslesen des Sync Journals
             * Senden der Änderungen über WebService
             */

        }

        public void PartialSync()
        {
            var data = wsc.PartialSync();
        }

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
