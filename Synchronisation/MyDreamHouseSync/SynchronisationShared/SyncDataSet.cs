using SynchronisationDataManager.Tables;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationShared
{
    public class SyncDataSet
    {
        public List<HauspaketAttribut> HauspaketAttributTable { get; set; }
        public List<HauspaketAttributWert> HauspaketAttributWertTable { get; set; }
        public List<HauspaketAttributRegel> HauspaketAttributRegelTable { get; set; }
        public List<HauspaketAttributZuord> HauspaketAttributZuordTable { get; set; }
        public List<Hersteller> HerstellerTable { get; set; }
        public List<Berater> BeraterTable { get; set; }
        public List<Hauspaket> HauspaketTable { get; set; }
        public List<Attachements> AttachementsTable { get; set; }

        public SyncDataSet()
        {
            HauspaketAttributTable = new List<HauspaketAttribut>();
            HauspaketAttributWertTable = new List<HauspaketAttributWert>();
            HauspaketAttributRegelTable = new List<HauspaketAttributRegel>();
            HauspaketTable = new List<Hauspaket>();
            AttachementsTable = new List<Attachements>();
            BeraterTable = new List<Berater>();
            HerstellerTable = new List<Hersteller>();
        }
    }
}
