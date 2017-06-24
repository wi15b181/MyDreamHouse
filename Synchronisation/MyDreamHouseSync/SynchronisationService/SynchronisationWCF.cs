using SynchronisationDataManager;
using SynchronisationDataManager.Tables;
using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationService
{
    // HINWEIS: Mit dem Befehl "Umbenennen" im Menü "Umgestalten" können Sie den Klassennamen "SynchronisationWCF" sowohl im Code als auch in der Konfigurationsdatei ändern.
    public class SynchronisationWCF : ISynchronisationWCF
    {
        private DataManager dataManager = new DataManager();

        public int Ping()
        {
            return 1;
        }

        public int SaveHauspaket(HauspaketDTO hauspaket)
        {
            try
            {
                dataManager.SaveHauspaket(hauspaket);
            }
            catch(Exception e)
            {
                Logger.Error(e.Message);
                return 0;
            }
            return 1;
        }

        public SyncDataSet Synchronize(string type, string lastSync)
        {
            SyncDataSet syncDataSet = new SyncDataSet();
            syncDataSet.HauspaketAttributTable = dataManager.GetAllHauspaketAttributInsert();
            syncDataSet.HauspaketAttributWertTable = dataManager.GetAllHauspaketAttributWertInsert();
            syncDataSet.HauspaketAttributRegelTable = dataManager.GetAllHauspaketAttributRegelInsert();
            syncDataSet.BeraterTable = dataManager.GetAllBeraterInsert();
            syncDataSet.HerstellerTable = dataManager.GetAllHerstellerInsert();
            syncDataSet.HauspaketTable = dataManager.GetAllHauspaketInsert();
            syncDataSet.AttachementsTable = dataManager.GetAllAttachementsInsert();
            syncDataSet.HauspaketAttributZuordTable = dataManager.GetAllHauspaketAttributZuordInsert();

            return syncDataSet;
        }
    }
}
