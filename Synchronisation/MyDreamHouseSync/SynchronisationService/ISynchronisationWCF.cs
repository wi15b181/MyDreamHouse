using SynchronisationDataManager.Tables;
using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using static SynchronisationService.SynchronisationWCF;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationService
{
    // HINWEIS: Mit dem Befehl "Umbenennen" im Menü "Umgestalten" können Sie den Schnittstellennamen "ISynchronisationWCF" sowohl im Code als auch in der Konfigurationsdatei ändern.
    [ServiceContract]
    public interface ISynchronisationWCF
    {
        [OperationContract]
        int Ping();

        [OperationContract]
        int SaveHauspaket(HauspaketDTO hauspaket);

        [OperationContract]
        SyncDataSet Synchronize(string type, string lastSync);
    }
}
