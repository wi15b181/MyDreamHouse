using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class HauspaketDTO : SyncData
    {
        public Nullable<int> HauspaketId { get; set; }
        public Nullable<int> HerstellerId { get; set; }
        public Nullable<int> BeraterId { get; set; }
        public string Bezeichnung { get; set; }
        public Nullable<double> Preis { get; set; }
        public Nullable<double> Grundflaeche { get; set; }
        public Nullable<double> Wohnflaeche { get; set; }
        public Nullable<int> Stockwerke { get; set; }
        public Nullable<int> BenutzerId { get; set; } 
        public string Archived { get; set; }
       
        public List<HauspaketAttributZuord> HauspaketAttributZuordnungen { get; set; }
        public List<Attachements> HauspaketAttachements { get; set; }
    }
}
