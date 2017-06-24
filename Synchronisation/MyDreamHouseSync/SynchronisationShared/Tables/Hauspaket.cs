using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Hauspaket : Table
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
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (hauspaket_id,hersteller_id,berater_id,bezeichnung,preis,grundflaeche,wohnflaeche,stockwerke,benutzer_id,archived) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);
            query = AddParam(query, row, 3, DataType.STRING, false);
            query = AddParam(query, row, 4, DataType.NUMERIC, false);
            query = AddParam(query, row, 5, DataType.NUMERIC, false);
            query = AddParam(query, row, 6, DataType.NUMERIC, false);
            query = AddParam(query, row, 7, DataType.NUMERIC, false);
            query = AddParam(query, row, 8, DataType.NUMERIC, false);
            query = AddParamPlain(query,"n", DataType.STRING, true);

            return query;
        }

        public override string GetTableName()
        {
            return "hauspaket";
        }

        public override string GetPrimaryKeyColumn()
        {
            return "hauspaket_id";
        }
    }
}
