﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;

namespace SynchronisationService
{
    // HINWEIS: Mit dem Befehl "Umbenennen" im Menü "Umgestalten" können Sie den Schnittstellennamen "ISynchronisationWCF" sowohl im Code als auch in der Konfigurationsdatei ändern.
    [ServiceContract]
    public interface ISynchronisationWCF
    {
        [OperationContract]
        int Ping();
    }
}
